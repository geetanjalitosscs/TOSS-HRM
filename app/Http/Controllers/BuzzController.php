<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuzzController extends Controller
{
    public function index()
    {
        // Sample buzz posts data
        $posts = [
            [
                'id' => 1,
                'user_name' => 'manda akhil user',
                'profile_pic' => '👤',
                'timestamp' => '2020-08-10 09:08 AM',
                'content' => 'Hi All: Linda has been blessed with a baby boy! Linda: With love, we welcome your dear new baby to this world. Congratulations!',
                'likes' => 0,
                'comments' => 0,
                'shares' => 0,
                'image' => null
            ],
            [
                'id' => 2,
                'user_name' => 'Sania Shaheen',
                'profile_pic' => '👩',
                'timestamp' => '2020-08-10 09:08 AM',
                'content' => 'Discussion about snooker players, mentioning "Mark Selby" and "John Higgins"...',
                'likes' => 1,
                'comments' => 0,
                'shares' => 0,
                'image' => null,
                'has_read_more' => true
            ],
            [
                'id' => 3,
                'user_name' => 'Rebecca Harmony',
                'profile_pic' => '👩',
                'timestamp' => '2020-08-10 09:04 AM',
                'content' => 'Throwback Thursdays!!',
                'likes' => 0,
                'comments' => 0,
                'shares' => 0,
                'image' => 'https://via.placeholder.com/600x400?text=Image+Post'
            ],
            [
                'id' => 4,
                'user_name' => 'Russel Hamilton',
                'profile_pic' => '👤',
                'timestamp' => '2020-08-10 09:03 AM',
                'content' => 'Live SIMPLY Dream BIG Be GREATFULL Give LOVE Laugh LOT.......',
                'likes' => 2,
                'comments' => 0,
                'shares' => 0,
                'image' => null
            ],
        ];

        return view('buzz.index', compact('posts'));
    }
}

