<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $foo = 'bar';
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertTitle('FACET')
                ->assertSee('FACET');
        });
    }
}
