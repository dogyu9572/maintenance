# Laravel Sail 설치 가이드
> PHP 8.4 + Laravel 12 + MySQL 8.0 + Docker 환경 구축

## 📋 프로젝트 개요

**목표**: 기존 PHP 프로젝트를 Laravel 12로 마이그레이션  
**환경**: WSL Ubuntu + Docker  
**기술스택**: PHP 8.4, Laravel 12, MySQL 8.0, Redis  
**설치일**: 2024년 12월

---

## 🏗️ 설치 과정

### 1단계: 프로젝트 구조 확인

```bash
# 현재 프로젝트 구조 확인
ls -la
```

**기존 구조**:
```
maintenance/
├── www/                    # 기존 PHP 프로젝트
│   ├── index.php
│   ├── main.php
│   ├── page/
│   ├── page_adm/
│   └── pub/
├── 퍼블리싱_분석_문서.md
└── 커서_개발_가이드.md
```

### 2단계: Docker 환경 설정

#### 2.1 Docker Compose 파일 생성
```yaml
# docker-compose.yml
services:
    laravel.test:
        build:
            context: ./vendor/laravel/sail/runtimes/8.4
            dockerfile: Dockerfile
            args:
                WWWGROUP: '${WWWGROUP}'
        image: sail-8.4/app
        ports:
            - '${APP_PORT:-80}:80'
        environment:
            WWWUSER: '${WWWUSER}'
            LARAVEL_SAIL: 1
        volumes:
            - '.:/var/www/html'
        networks:
            - sail
        depends_on:
            - mysql
            - redis
    mysql:
        image: 'mysql/mysql-server:8.0'
        ports:
            - '${FORWARD_DB_PORT:-3306}:3306'
        environment:
            MYSQL_ROOT_PASSWORD: '${DB_PASSWORD}'
            MYSQL_DATABASE: '${DB_DATABASE}'
            MYSQL_USER: '${DB_USERNAME}'
            MYSQL_PASSWORD: '${DB_PASSWORD}'
        volumes:
            - 'sail-mysql:/var/lib/mysql'
        networks:
            - sail
    redis:
        image: 'redis:alpine'
        ports:
            - '${FORWARD_REDIS_PORT:-6379}:6379'
        volumes:
            - 'sail-redis:/data'
        networks:
            - sail
```

#### 2.2 환경 변수 설정
```bash
# .env 파일에 추가
WWWUSER=1000
WWWGROUP=1000
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=maintenance_board
DB_USERNAME=sail
DB_PASSWORD=password
```

### 3단계: Laravel 프로젝트 생성

#### 3.1 Composer를 통한 Laravel 설치
```bash
# Laravel 프로젝트 생성
composer create-project laravel/laravel temp-laravel

# 파일 복사
cp -r temp-laravel/* .
cp -r temp-laravel/.* . 2>/dev/null || true

# 임시 디렉토리 정리
rm -rf temp-laravel
```

#### 3.2 Laravel 키 생성
```bash
php artisan key:generate
```

### 4단계: Docker 설정 파일 생성

#### 4.1 Dockerfile 생성
```dockerfile
FROM ubuntu:22.04

LABEL maintainer="Taylor Otwell"

ARG WWWGROUP
ARG NODE_VERSION=20

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

# PHP 8.4 및 필요한 패키지 설치
RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /usr/share/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.4-cli php8.4-dev php8.4-pgsql php8.4-sqlite3 php8.4-gd php8.4-imagick php8.4-curl php8.4-imap php8.4-mysql php8.4-mbstring php8.4-xml php8.4-zip php8.4-bcmath php8.4-soap php8.4-intl php8.4-readline php8.4-ldap php8.4-msgpack php8.4-igbinary php8.4-redis php8.4-swoole php8.4-memcached php8.4-xdebug

# Composer 설치
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Node.js 설치
RUN curl -fsSL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# 사용자 생성
RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

EXPOSE 8000

ENTRYPOINT ["start-container"]
```

#### 4.2 PHP 설정 파일들 생성
```bash
# 디렉토리 생성
mkdir -p docker/8.4

# PHP 설정 파일들 생성
# docker/8.4/php.ini
# docker/8.4/xdebug.ini
# docker/8.4/php-fpm.conf
# docker/8.4/www.conf
# docker/8.4/supervisord.conf
# docker/8.4/start-container
```

### 5단계: Sail 스크립트 설정

#### 5.1 Sail 스크립트 생성
```bash
# sail 스크립트 생성 및 권한 설정
chmod +x sail
```

#### 5.2 줄바꿈 문자 수정 (Windows → Linux)
```bash
# Windows 줄바꿈 문자를 Linux 형식으로 변환
sed -i 's/\r$//' sail
```

### 6단계: Docker Compose 실행

#### 6.1 버전 속성 제거
```yaml
# docker-compose.yml에서 version: '3' 제거
# 최신 Docker Compose에서는 version 속성이 불필요
```

#### 6.2 컨테이너 시작
```bash
# Docker Compose로 컨테이너 시작
docker-compose up -d
```

### 7단계: 의존성 설치

#### 7.1 Composer 의존성 설치
```bash
# Laravel 의존성 설치
composer install
```

---

## 🔧 해결한 문제들

### 1. Windows 줄바꿈 문자 문제
**문제**: `\r\n` 줄바꿈으로 인한 실행 오류  
**해결**: `sed -i 's/\r$//' sail` 명령어로 변환

### 2. 환경 변수 누락 문제
**문제**: Docker Compose 경고 메시지  
**해결**: `.env` 파일에 필요한 환경 변수 추가

### 3. Docker Compose 버전 경고
**문제**: `version` 속성이 obsolete  
**해결**: `docker-compose.yml`에서 `version: '3'` 제거

### 4. Laravel 컨테이너 클래스 오류
**문제**: `Class "Illuminate\Container\Container" not found`  
**해결**: `composer install`로 의존성 재설치

---

## ✅ 최종 결과

### 성공적으로 설치된 환경
- ✅ **PHP 8.4** - 최신 PHP 버전
- ✅ **Laravel 12** - 최신 Laravel 프레임워크
- ✅ **MySQL 8.0** - 데이터베이스 서버
- ✅ **Redis** - 캐시 및 세션 저장소
- ✅ **Docker** - 컨테이너화된 개발 환경

### 접속 정보
- **웹 애플리케이션**: http://localhost
- **데이터베이스**: localhost:3306
- **Redis**: localhost:6379

---

## 🚀 다음 단계

### 1. 데이터베이스 마이그레이션
```bash
docker-compose exec laravel.test php artisan migrate
```

### 2. 기존 프로젝트 분석
- `www/` 디렉토리의 기존 PHP 코드 분석
- 데이터베이스 구조 파악
- 디자인 시스템 분석

### 3. Laravel 컨버팅 계획
- 컨트롤러 생성
- 모델 생성
- 마이그레이션 파일 작성
- 블레이드 템플릿 생성

---

## 📚 참고 자료

- [Laravel Sail 공식 문서](https://laravel.com/docs/sail)
- [Docker Compose 문서](https://docs.docker.com/compose/)
- [Laravel 12 문서](https://laravel.com/docs)

---

*이 문서는 Laravel Sail 설치 과정을 기록한 것입니다.* 
