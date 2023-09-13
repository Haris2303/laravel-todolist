<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'udinsurudin'
        ])->get('/login')->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'udinsurudin',
            'password' => '12345'
        ])->assertSessionHas('user', 'udinsurudin');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user' => 'udinsurudin'
        ])->post('/login', [
            'user' => 'udinsurudin',
            'password' => '12345'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])->assertSeeText('User and password is required');
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'fail',
            'password' => 'fail'
        ])->assertSeeText('User or password is wrong');
    }

    public function testLogout()
    {
        $this->withSession([
            'user' => 'udinsurudin'
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('user');
    }
}
