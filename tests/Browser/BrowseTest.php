<?php

namespace Tests\Browser;

use App\Link;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BrowseTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_see_links_on_homepage()
    {
        $user = factory(User::class)->create();
        $link1 = factory(Link::class)->create();
        $link2 = factory(Link::class)->state('private')->create();

        $this->browse(function (Browser $browser) use ($user, $link1, $link2) {
            $browser->visit('/')
                ->assertSee('Connexion')
                ->assertSee($link1->title)
                ->assertDontSee($link2->title);

            $browser->loginAs(1)
                ->visit('/')
                ->assertSee($user->name)
                ->assertSee($link1->title)
                ->assertSee($link2->title);
        });
    }
}
