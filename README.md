<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🛠️ 유지보수 관리 시스템

Laravel 12 기반의 유지보수 관리 시스템입니다.

## 📋 프로젝트 개요

- **프로젝트명**: 유지보수 관리 시스템 (Maintenance Management System)
- **기술 스택**: Laravel 12, MySQL, WSL Ubuntu
- **개발 환경**: Docker, PHP 8.4
- **프로젝트 상태**: 개발 완료

## 🚀 주요 기능

- **유지보수 요청 관리**: 클라이언트별 유지보수 요청 등록 및 관리
- **월간 보고서**: 월별 유지보수 현황 보고서 생성 및 출력
- **공지사항**: 시스템 내 공지사항 관리 및 파일 첨부
- **알림 시스템**: 실시간 알림 기능
- **계정 관리**: 사용자 및 관리자 계정 관리
- **통계 대시보드**: 유지보수 현황 통계 제공

## 🚀 빠른 시작

### 1단계: 프로젝트 설정
```bash
./setup-project.sh
```

### 2단계: 데이터베이스 설정
```bash
./setup-database.sh
```

### 3단계: 접속
- **애플리케이션**: http://localhost
- **관리자 계정**: homepage / homepagekorea

## 📚 문서

프로젝트 관련 모든 문서는 [docs](./docs/) 폴더에서 확인할 수 있습니다:

### 📋 핵심 문서
- [📋 문서 목록](./docs/README.md) - 전체 문서 가이드
- [🗄️ DB 설계 및 작업 계획](./docs/01_DB_설계_및_작업_계획.md) - 데이터베이스 설계 및 프로젝트 계획
- [⚙️ Laravel 설치 가이드](./docs/02_Laravel_설치_가이드.md) - WSL 환경에서 Laravel 12 설치
- [🚀 프로젝트 설정 가이드](./docs/08_프로젝트_설정_가이드.md) - 프로젝트 설정 및 실행 가이드

### 🛠️ 개발 문서
- [🗃️ 데이터베이스 마이그레이션 작업 정리](./docs/03_데이터베이스_마이그레이션_작업_정리.md) - 마이그레이션 작업 과정 및 결과
- [🎨 퍼블리싱 분석 문서](./docs/04_퍼블리싱_분석_문서.md) - 기존 퍼블리싱 파일 분석 및 구조
- [🛠️ 커서 개발 가이드](./docs/05_커서_개발_가이드.md) - Cursor IDE를 사용한 개발 가이드

### 🧪 테스트 및 디버깅
- [🧪 TDD 가이드](./docs/06_TDD_가이드.md) - 테스트 주도 개발 가이드
- [🐛 디버깅 가이드](./docs/07_디버깅_가이드.md) - 디버깅 및 문제 해결 가이드

### 📊 프로젝트 현황
- **개발 완료**: 모든 핵심 기능 구현 완료
- **문서 완성**: 7개 주요 문서 작성 완료
- **테스트 준비**: TDD 가이드 및 디버깅 가이드 포함

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
