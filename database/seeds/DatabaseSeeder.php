<?php

use App\Chest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Mail::fake();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret'),
            'api_token' => 'api-token-secret',
            'is_admin' => 1,
            'created_at' => now()->toDateTimeString(),
        ]);

        $items = [
            \App\Story::create([
                'title' => '21 Behaviors That Will Make You Brilliant',
                'slug' => '21-behaviors-that-will-make-you-brilliant',
                'content' => "When you see things from multiple perspectives, you realize you can achieve almost anything you want in far less time than you imagined.   Yet most people have fixed and limited views about themselves and what they can accomplish.  They have fixed and limited views about the resources available to them.",
            ]),
            \App\Link::create([
                'title' => 'The PHP Framework for Web Artisans',
                'content' => 'Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.',
                'url' => 'https://laravel.com/',
            ]),
            \App\Link::create([
                'title' => "Pandrezz X L'indécis X j'san - Belleville EP",
                'url' => 'https://soundcloud.com/pandrezz/pandrezz-x-lindecis-x-jsan-belleville-ep',
                'preview' => '<iframe width="100%" height="140" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?visual=false&url=https%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F563826981&show_artwork=false"></iframe>',
            ]),
            \App\Link::create([
                'title' => 'Morten Granau - Scope (Official Audio)',
                'url' => 'https://www.youtube.com/watch?v=uQbUzL0VE7w',
                'preview' => '<iframe width="100%" src="https://www.youtube.com/embed/uQbUzL0VE7w" frameborder="0" allowfullscreen></iframe>'
            ]),
            \App\Chest::create([
                'title' => config('app.name'),
                'content' => [
                    ['type' => 'url', 'name' => 'URL', 'value' => route('login')],
                    ['type' => 'text', 'name' => 'Email', 'value' => 'admin@example.fr'],
                    ['type' => 'password', 'name' => 'Mot de passe', 'value' => Str::random(12)],
                    ['type' => 'code', 'name' => 'Code', 'value' => "<?php\n\nnamespace App\\Service;\n\nclass Foobar {\n\n\n}\n"],
                ]
            ]),
        ];

        foreach ($items as $item) {
            $post = new App\Post(['is_private' => get_class($item) === Chest::class, 'user_id' => 1]);
            $item->post()->save($post);
        }

        $items[0]->post->attachTag('Web');
        $items[1]->post->attachTag('Web');
        $items[2]->post->attachTag('Musique');
        $items[3]->post->attachTag('Musique');
        $items[4]->post->attachTag('Compte');
    }
}
