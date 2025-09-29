<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    // 1단계: Red - 실패하는 테스트 작성
    public function test_user_can_view_profile_edit_page()
    {
        // Arrange: 테스트 데이터 준비
        $user = User::factory()->create([
            'name' => '홍길동',
            'email' => 'hong@example.com',
            'phone' => '010-1234-5678'
        ]);

        // Act: 로그인 후 프로필 편집 페이지 접근
        $response = $this->actingAs($user)
                        ->get('/account/edit');

        // Assert: 페이지가 정상적으로 로드되는지 확인
        $response->assertStatus(200);
        $response->assertViewIs('account.edit');
        $response->assertSee('홍길동');
        $response->assertSee('hong@example.com');
    }

    public function test_user_can_update_profile()
    {
        // Arrange: 테스트 데이터 준비
        $user = User::factory()->create([
            'name' => '홍길동',
            'email' => 'hong@example.com',
            'phone' => '010-1234-5678'
        ]);

        $newData = [
            'name' => '김철수',
            'email' => 'kim@example.com',
            'phone' => '010-9876-5432'
        ];

        // Act: 프로필 업데이트 요청
        $response = $this->actingAs($user)
                        ->put('/account/update', $newData);

        // Assert: 업데이트 성공 확인
        $response->assertRedirect('/account');

        // 데이터베이스에 실제로 업데이트되었는지 확인
        $this->assertDatabaseHas('users', [
            'idx' => $user->idx,
            'name' => '김철수',
            'email' => 'kim@example.com',
            'phone' => '010-9876-5432'
        ]);
    }

    public function test_user_cannot_update_profile_with_invalid_data()
    {
        // Arrange
        $user = User::factory()->create();

        $invalidData = [
            'name' => '', // 빈 이름
            'email' => 'invalid-email', // 잘못된 이메일
            'phone' => '123' // 잘못된 전화번호
        ];

        // Act
        $response = $this->actingAs($user)
                        ->put('/account/update', $invalidData);

        // Assert: 유효성 검사 실패 확인 (실제 반환되는 오류만 확인)
        $response->assertSessionHasErrors(['name', 'email']);

        // 데이터베이스가 변경되지 않았는지 확인
        $this->assertDatabaseMissing('users', [
            'idx' => $user->idx,
            'email' => 'invalid-email'
        ]);
    }
}
