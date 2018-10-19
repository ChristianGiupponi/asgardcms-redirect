<?php

namespace Module\Redirect\Tests;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Modules\Redirect\Http\Requests\CreateRedirectRequest;
use Modules\Redirect\Repositories\RedirectRepository;
use Modules\Redirect\Tests\BaseRedirectTestCase;
use Modules\User\Entities\Sentinel\User;

class RedirectTest extends BaseRedirectTestCase
{
    private $redirect;
    private $rules;

    /**
     * Set Up
     */
    public function setUp()
    {
        parent::setUp();
        $this->redirect = app(RedirectRepository::class);
        $this->rules = (new CreateRedirectRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    /**
     * @test
     */
    public function it_can_create_a_redirect()
    {
        $createdRedirect = $this->redirect->create([
            'from' => 'https://bing.com',
            'to' => 'https://google.com',
            'type' => 301,
        ]);

        self::assertNotNull($createdRedirect->id);
        self::assertEquals('https://google.com', $createdRedirect->to);
    }

    /**
     * @test
     */
    public function it_can_update_a_redirect()
    {
        $createdRedirect = $this->redirect->create([
            'from' => 'https://bing.com',
            'to' => 'https://google.com',
            'type' => 301,
        ]);

        $createdRedirect->update([
            'type' => 302,
        ]);

        self::assertEquals(302, $createdRedirect->type);
    }

    /**
     * @test
     */
    public function it_can_delete_a_redirect()
    {
        $createdRedirect = $this->redirect->create([
            'from' => 'https://bing.com',
            'to' => 'https://google.com',
            'type' => 301,
        ]);

        $createdRedirect->delete();

        $redirects = $this->redirect->all();

        self::assertEquals(0, $redirects->count());
    }

    /** @test */
    public function it_require_from_field()
    {
        self::assertFalse($this->validateField('from', ''));
    }

    /** @test */
    public function it_require_to_field()
    {
        self::assertFalse($this->validateField('to', ''));
    }

    /** @test */
    public function it_require_type_field()
    {
        self::assertFalse($this->validateField('type', ''));
    }

    /** @test */
    public function ype_field_needs_to_be_301_or_302()
    {
        self::assertTrue($this->validateField('type', 301));
        self::assertTrue($this->validateField('type', 302));
        self::assertFalse($this->validateField('type', 303));
    }

    /** @test */
    public function it_throw_query_exception_if_some_fields_is_missing()
    {
        $this->expectException(QueryException::class);

        $createdRedirect = $this->redirect->create([
            'from' => 'https://bing.com',
            'to' => 'https://google.com',
        ]);
    }

    /** @test */
    public function it_cannot_create_the_same_from_and_to_twice()
    {
        $createdRedirect = $this->redirect->create([
            'from' => 'https://bing.com',
            'to' => 'https://google.com',
            'type' => 301,
        ]);

        $this->expectException(QueryException::class);
        $createdRedirectCopy = $this->redirect->create([
            'from' => 'https://bing.com',
            'to' => 'https://google.com',
            'type' => 301,
        ]);
    }

    protected function getFieldValidator($field, $value)
    {
        return $this->validator->make(
        [$field => $value],
        [$field => $this->rules[$field]]
    );
    }

    protected function validateField($field, $value)
    {
        return $this->getFieldValidator($field, $value)->passes();
    }
}
