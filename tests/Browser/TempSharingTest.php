<?php

namespace Tests\Browser;

use App\Post;
use App\Share;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TempSharingTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_share_link()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('private', 'link')->create();

        $this->browse(function (Browser $browser) use ($user, $post) {
            $browser
                ->loginAs(1)
                ->visitRoute('home')
                ->assertSee($post->postable->title)
                ->click('.card-footer button#dropdownMenuButton')
                ->assertSee('Temp sharing')
                ->click('.card-footer div.dropdown-menu a:nth-child(5)')
                ->waitForText('Link expires in')
                ->press('Generate')
                ->waitForText('Link generated');

            $share = Share::first();

            $browser
                ->logout()
                ->visitRoute('share', [$share->id, $share->token])
                ->assertSee($post->postable->title);

            $share->expires_at = $share->expires_at->subHour();
            $share->save();

            $browser
                ->visitRoute('share', [$share->id, $share->token])
                ->assertSee('This shared content has expired');

        });
    }

    /** @test */
    public function it_can_share_chest()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('private', 'chest')->create();

        $this->browse(function (Browser $browser) use ($user, $post) {
            $browser
                ->loginAs(1)
                ->visitRoute('home')
                ->assertSee($post->postable->title)
                ->click('.card-footer button#dropdownMenuButton')
                ->assertSee('Temp sharing')
                ->click('.card-footer div.dropdown-menu a:nth-child(3)')
                ->waitForText('Link expires in')
                ->press('Generate')
                ->waitForText('Link generated');

            $share = Share::first();

            $browser
                ->logout()
                ->visitRoute('share', [$share->id, $share->token])
                ->assertSee($post->postable->title);

            $share->expires_at = $share->expires_at->subHour();
            $share->save();

            $browser
                ->visitRoute('share', [$share->id, $share->token])
                ->assertSee('This shared content has expired');

        });
    }

    /** @test */
    public function it_can_share_story()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('private', 'story')->create();

        $this->browse(function (Browser $browser) use ($user, $post) {
            $browser
                ->loginAs(1)
                ->visitRoute('home')
                ->assertSee($post->postable->title)
                ->click('.card-footer button#dropdownMenuButton')
                ->assertSee('Temp sharing')
                ->click('.card-footer div.dropdown-menu a:nth-child(3)')
                ->waitForText('Link expires in')
                ->press('Generate')
                ->waitForText('Link generated');

            $share = Share::first();

            $browser
                ->logout()
                ->visitRoute('share', [$share->id, $share->token])
                ->assertSee($post->postable->title);

            $share->expires_at = $share->expires_at->subHour();
            $share->save();

            $browser
                ->visitRoute('share', [$share->id, $share->token])
                ->assertSee('This shared content has expired');

        });
    }
}
