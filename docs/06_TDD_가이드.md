# TDD (Test-Driven Development) 가이드

## 개요

이 프로젝트는 테스트 주도 개발(TDD) 방식을 채택하여 개발됩니다. TDD는 코드의 품질과 안정성을 보장하는 효과적인 개발 방법론입니다.

## TDD 원칙

### Red-Green-Refactor 사이클

1. **Red**: 실패하는 테스트 작성
2. **Green**: 테스트를 통과하는 최소한의 코드 작성
3. **Refactor**: 코드 개선 (기능은 유지)

## 프로젝트 테스트 구조

```
tests/
├── Feature/           # 기능 테스트 (HTTP 요청, 라우트, 컨트롤러)
│   ├── AuthControllerTest.php
│   ├── ExampleTest.php
│   └── UserProfileTest.php
├── Unit/             # 단위 테스트 (모델, 서비스 클래스)
│   ├── ExampleTest.php
│   └── UserTest.php
├── TestCase.php      # 기본 테스트 클래스
└── TestHelper.php    # 공통 테스트 헬퍼
```

## 테스트 실행 방법

### 전체 테스트 실행
```bash
php artisan test
```

### 특정 테스트 스위트 실행
```bash
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

### 특정 테스트 파일 실행
```bash
php artisan test tests/Feature/AuthControllerTest.php
```

### 특정 테스트 메서드 실행
```bash
php artisan test --filter test_login_with_valid_credentials
```

### 테스트 커버리지 확인
```bash
php artisan test --coverage
```

## 현재 설정된 테스트 환경

### phpunit.xml 설정
- **데이터베이스**: MySQL (`maintenance_test`)
- **호스트**: 127.0.0.1:3306
- **사용자**: root (비밀번호 없음)
- **환경**: testing

### 테스트 데이터베이스 설정
```sql
CREATE DATABASE maintenance_test;
```

## TDD 개발 워크플로우

### 1. 기능 개발 시

1. **테스트 작성**: 새로운 기능에 대한 테스트를 먼저 작성
2. **테스트 실행**: 실패하는 것을 확인 (Red)
3. **코드 구현**: 테스트를 통과하는 최소한의 코드 작성
4. **테스트 실행**: 통과하는 것을 확인 (Green)
5. **리팩토링**: 코드 개선 (Refactor)

### 2. 버그 수정 시

1. **재현 테스트 작성**: 버그를 재현하는 테스트 작성
2. **테스트 실행**: 실패하는 것을 확인
3. **버그 수정**: 테스트를 통과하도록 수정
4. **테스트 실행**: 통과하는 것을 확인

## 테스트 작성 가이드

### Feature 테스트 (기능 테스트)

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_example_feature()
    {
        // Arrange (준비)
        $user = User::factory()->create();

        // Act (실행)
        $response = $this->actingAs($user)
                        ->get('/example-route');

        // Assert (검증)
        $response->assertStatus(200);
        $response->assertViewIs('example.view');
    }
}
```

### Unit 테스트 (단위 테스트)

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_method()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'admin']);

        // Act & Assert
        $this->assertTrue($user->isAdmin());
    }
}
```

## TestHelper 사용법

현재 구현된 TestHelper는 다음과 같은 헬퍼 메서드들을 제공합니다:

```php
use Tests\TestHelper;

class ExampleTest extends TestCase
{
    use TestHelper;

    public function test_example()
    {
        // 사용자 생성
        $user = $this->createUser();
        $admin = $this->createAdmin();
        
        // 로그인
        $this->loginAsUser($user);
        $this->loginAsAdmin($admin);
        
        // 모델 생성
        $client = $this->createClient();
        $maintenanceType = $this->createMaintenanceType();
        $requestStatus = $this->createRequestStatus();
        $maintenanceRequest = $this->createMaintenanceRequest();
        $notice = $this->createNotice();
        $monthlyReport = $this->createMonthlyReport();
        
        // 완전한 유지보수 요청 생성
        $completeRequest = $this->createCompleteMaintenanceRequest();
        
        // 검증 헬퍼
        $this->assertModelHasAttributes($model, ['name' => 'value']);
        $this->assertValidationErrors($response, ['field']);
        $this->assertNoValidationErrors($response);
        
        // 테스트 데이터 생성
        $requestData = $this->getMaintenanceRequestData();
        $userData = $this->getUserRegistrationData();
    }
}
```

## 현재 구현된 Factory

### UserFactory
- 기본 사용자 생성
- `admin()` 메서드로 관리자 생성
- `unverified()` 메서드로 미인증 사용자 생성

### MaintenanceTypeFactory
- 기본 유지보수 유형 생성
- `inactive()` 메서드로 비활성 유형 생성

## 테스트 데이터베이스

- **환경**: MySQL (`maintenance_test` 데이터베이스)
- **설정**: `phpunit.xml`에서 테스트 환경 변수 설정
- **마이그레이션**: 각 테스트 실행 시 자동으로 마이그레이션 실행

## 모범 사례

### 1. 테스트 네이밍
- `test_메서드명_시나리오_예상결과` 형태로 작성
- 예: `test_login_with_valid_credentials_redirects_to_home`

### 2. 테스트 구조
- **Arrange**: 테스트 데이터 준비
- **Act**: 테스트할 동작 실행
- **Assert**: 결과 검증

### 3. 테스트 격리
- 각 테스트는 독립적으로 실행되어야 함
- `RefreshDatabase` 트레이트 사용으로 데이터 격리

### 4. Mock 사용
```php
use Mockery;

public function test_with_mock()
{
    $mock = Mockery::mock(Service::class);
    $mock->shouldReceive('method')->once()->andReturn('result');
    
    // 테스트 로직
}
```

## 현재 구현된 테스트

### AuthControllerTest
- 로그인 폼 표시 테스트
- 유효한 자격증명으로 로그인 테스트
- 잘못된 자격증명으로 로그인 테스트
- 관리자 로그인 후 대시보드 리다이렉트 테스트
- 로그아웃 테스트

## 문제 해결

### 일반적인 문제들

1. **테스트 데이터베이스 연결 오류**
   - MySQL 서버가 실행 중인지 확인
   - `maintenance_test` 데이터베이스가 존재하는지 확인
   - 마이그레이션 실행: `php artisan migrate --env=testing`

2. **Factory 오류**
   - Factory 정의가 모델 필드와 일치하는지 확인
   - 필요한 필드가 `$fillable`에 포함되어 있는지 확인

3. **인증 테스트 오류**
   - `actingAs()` 메서드 사용
   - 세션 및 쿠키 설정 확인

## 추가 리소스

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [TDD by Example (Kent Beck)](https://www.amazon.com/Test-Driven-Development-Kent-Beck/dp/0321146530) 
