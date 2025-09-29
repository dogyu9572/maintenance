<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>월간보고서 - {{ $report->title }}</title>
    
    <!-- Pretendard 웹폰트 로드 -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" as="style" crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/static/pretendard.min.css">
    
    <!-- 퍼블리싱 CSS 파일들 불러오기 -->
    <link rel="stylesheet" href="/css/styles.css" media="all">
    <link rel="stylesheet" href="/css/reactive.css" media="all">
    
    <style>
        @media print {
            @page {margin:0; size: A4;}
            .transaction_statement {page-break-inside: avoid;}
        }
        
        /* 퍼블리싱과 동일한 폰트 및 스타일 (출력 페이지 내에서만) */
        body.print-page {
            font-family: 'Pretendard', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-size: 13px;
            font-weight: 400;
            color: #333;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-feature-settings: 'tnum' on, 'lnum' on;
        }
        
        /* Pretendard 폰트 적용 (출력 페이지 내에서만) */
        body.print-page .monthly_reports_print,
        body.print-page .monthly_reports_print * {
            font-family: 'Pretendard', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }
        
        /* 월간보고서 출력 스타일 */
        .monthly_reports_print {
            width: 595pt;
            margin: 0 auto;
            line-height: 1.4;
        }
        
        .monthly_reports_print .head {
            position: relative;
            background: #F4F6FA;
            padding: 40pt 40pt 24pt;
        }
        
        .monthly_reports_print .title {
            font-size: 32pt;
            color: #21293B;
            font-weight: 700;
            margin-bottom: 8pt;
        }
        
        .monthly_reports_print .date {
            position: absolute;
            top: 40pt;
            right: 40pt;
            font-size: 10pt;
            color: #7A7F89;
            font-weight: 500;
        }
        
        .monthly_reports_print .tit {
            font-size: 18pt;
            color: #21293B;
            font-weight: 500;
            margin-bottom: 24pt;
        }
        
        .monthly_reports_print .tit strong {
            color: #1466D6;
        }
        
        .monthly_reports_print .head .tbl {
            border: #EAEDF4 1pt solid;
            border-radius: 4pt;
            background: #fff;
            padding: 8pt 16pt;
        }
        
        .monthly_reports_print .head .tbl th,
        .monthly_reports_print .head .tbl td {
            font-size: 10pt;
            padding: 4pt 5pt;
        }
        
        .monthly_reports_print .head .tbl th {
            color: #475067;
            font-weight: 500;
            width: 68pt;
        }
        
        .monthly_reports_print .head .tbl td {
            color: #21293B;
            font-weight: 600;
        }
        
        .monthly_reports_print .body {
            padding: 32pt 40pt 40pt;
        }
        
        .monthly_reports_print .body th,
        .monthly_reports_print .body td {
            font-size: 10pt;
            line-height: 30pt;
            padding: 0 5px;
            border-bottom: #EAEDF4 1px solid;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .monthly_reports_print .body thead th {
            color: #fff;
            font-weight: 500;
            background: #21293B;
        }
        
        .monthly_reports_print .body tbody th {
            color: #475067;
            font-weight: 500;
            background: #F4F6FA;
        }
        
        .monthly_reports_print .body tbody td {
            color: #21293B;
        }
        
        .monthly_reports_print .body .tbl2 {
            margin-top: 24pt;
        }
        
        .monthly_reports_print .body .tbl2 td {
            height: 100pt;
            padding: 10pt;
            vertical-align: top;
        }
    </style>
</head>
<body class="print-page">
    <div id="printarea">
        <div class="monthly_reports_print">
            <div class="head">
                <div class="title">월간보고서</div>
                <div class="date">보고일 : {{ $report->created_at ? $report->created_at->format('Y년 m월 d일') : 'YYYY년 MM월 DD일' }}</div>
                    
                <div class="tit"><strong>{{ $report->year }}년 {{ $report->month }}월</strong> 유지보수 업무현황</div>
                <div class="tbl">
                    <table>
                        <tbody>
                            <tr>
                                <th>· 사업명</th>
                                <td>{{ $report->client->name ?? '' }} 유지보수 진행업무</td>
                            </tr>
                            <tr>
                                <th>· 업무기간</th>
                                <td>
                                    @if($report->work_start_date && $report->work_end_date)
                                        {{ \Carbon\Carbon::parse($report->work_start_date)->format('Y.m.d') }}~{{ \Carbon\Carbon::parse($report->work_end_date)->format('Y.m.d') }}
                                    @else
                                        {{ $report->year }}.{{ str_pad($report->month, 2, '0', STR_PAD_LEFT) }}.01~{{ $report->year }}.{{ str_pad($report->month, 2, '0', STR_PAD_LEFT) }}.{{ date('t', mktime(0, 0, 0, $report->month, 1, $report->year)) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>· 용역책임자</th>
                                <td>{{ $report->manager_name ?? '홈리아' }}</td>
                            </tr>
                            <tr>
                                <th>· 사업책임자</th>
                                <td>{{ $report->company_name ?? '홈페이지코리아' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        
            <div class="body">
                <table class="tbl1">
                    <colgroup>
                        <col width="9%">
                        <col width="6%">
                        <col width="*">
                        <col width="10%">
                        <col width="11%">
                        <col width="13%">
                        <col width="13%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th></th>
                            <th>NO.</th>
                            <th>내용</th>
                            <th>진행율(%)</th>
                            <th>처리상태</th>
                            <th>접수일</th>
                            <th>완료일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($report->content)
                            @php
                                $lines = explode("\n", $report->content);
                                $lineNumber = 1;
                                $validLines = array_filter($lines, function($l) { return trim($l) && !str_starts_with(trim($l), '['); });
                            @endphp
                            @if(count($validLines) > 0)
                                @foreach($validLines as $line)
                                    <tr>
                                        @if($lineNumber === 1)
                                            <th rowspan="{{ count($validLines) }}">업무내용</th>
                                        @endif
                                        <td class="tac">{{ $lineNumber }}</td>
                                        <td>{{ trim($line) }}</td>
                                        <td>100</td>
                                        <td>완료</td>
                                        <td>{{ $report->created_at ? $report->created_at->format('Y.m.d') : '' }}</td>
                                        <td>{{ $report->created_at ? $report->created_at->format('Y.m.d') : '' }}</td>
                                    </tr>
                                    @php $lineNumber++; @endphp
                                @endforeach
                            @else
                                <tr>
                                    <th>업무내용</th>
                                    <td colspan="6" class="tac" style="color: #7A7F89; font-style: italic;">업무내용이 없습니다.</td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <th>업무내용</th>
                                <td colspan="6" class="tac" style="color: #7A7F89; font-style: italic;">업무내용이 없습니다.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <table class="tbl2">
                    <thead>
                        <tr>
                            <th>특이사항</th>
                        </tr>
                    </thead>
                                            <tbody>
                            <tr>
                                <td>
                                    @if($report->content)
                                        @php
                                            $specialNotes = '';
                                            foreach($lines as $line) {
                                                if(str_starts_with(trim($line), '[특이사항]')) {
                                                    $specialNotes = trim(str_replace('[특이사항]', '', $line));
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if($specialNotes)
                                            {{ $specialNotes }}
                                        @else
                                            <span style="color: #7A7F89; font-style: italic;">특이사항이 없습니다.</span>
                                        @endif
                                    @else
                                        <span style="color: #7A7F89; font-style: italic;">특이사항이 없습니다.</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- jQuery 불러오기 -->
    <script src="//code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // 페이지 로드 시 바로 인쇄를 시작
            window.print();

            // 인쇄 대화 상자가 닫힌 후 실행되는 함수
            $(window).on("afterprint", function() {
                // 페이지를 닫습니다.
                window.close();
            });

            // 인쇄가 취소되거나 실패할 경우를 대비하여 페이지를 닫습니다.
            $(window).on("beforeunload", function() {
                window.close();
            });
        });
    </script>
</body>
</html>
