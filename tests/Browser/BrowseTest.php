<?php

namespace Tests\Browser;

use App\Link;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

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
                ->assertSee($link2->title)
                ->logout()
                ->assertGuest();
        });
    }

    /** @test */
    public function it_test_link_view()
    {
        $user = factory(User::class)->create();
        $link1 = factory(Link::class)->create();
        $link2 = factory(Link::class)->state('private')->create();

        $this->browse(function (Browser $browser) use ($link1, $link2, $user) {
            $browser
                ->assertGuest()
                ->visitRoute('link.view', [$link1->hash_id])
                ->assertSee($link1->title)
                ->visitRoute('link.view', [$link2->hash_id])
                ->assertSee('404')
                ->loginAs(1)
                ->visitRoute('link.view', [$link2->hash_id])
                ->assertSee($link2->title)
                ->logout();
        });
    }
}
