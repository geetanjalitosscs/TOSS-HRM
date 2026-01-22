<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuzzController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'recent'); // 'recent', 'liked', 'commented'

        // Sample posts data - Most Recent Posts
        $recentPosts = [
            [
                'id' => 1,
                'user_name' => 'manda akhil user',
                'profile_pic' => 'M',
                'profile_color' => 'from-purple-400 to-purple-600',
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
                'profile_pic' => 'S',
                'profile_color' => 'from-yellow-400 to-yellow-600',
                'timestamp' => '2020-08-10 09:08 AM',
                'content' => 'World Championship: What makes the perfect snooker player? "Mark Selby": "You need to be mentally strong and have a good technique." "John Higgins": "Consistency and practice are key to success."',
                'likes' => 1,
                'comments' => 0,
                'shares' => 0,
                'image' => null,
                'has_read_more' => true
            ],
            [
                'id' => 3,
                'user_name' => 'Rebecca Harmony',
                'profile_pic' => 'R',
                'profile_color' => 'from-pink-400 to-pink-600',
                'timestamp' => '2020-08-10 09:04 AM',
                'content' => 'Throwback Thursdays!!',
                'likes' => 0,
                'comments' => 0,
                'shares' => 0,
                'image' => 'https://via.placeholder.com/600x400?text=Throwback+Photo'
            ],
            [
                'id' => 4,
                'user_name' => 'Russel Hamilton',
                'profile_pic' => 'R',
                'profile_color' => 'from-blue-400 to-blue-600',
                'timestamp' => '2020-08-10 09:03 AM',
                'content' => 'Live SIMPLY Dream BIG Be GREATFULL Give LOVE Laugh LOT.......',
                'likes' => 2,
                'comments' => 0,
                'shares' => 0,
                'image' => null
            ],
        ];

        // Most Liked Posts (sorted by likes)
        $likedPosts = [
            [
                'id' => 4,
                'user_name' => 'Russel Hamilton',
                'profile_pic' => 'R',
                'profile_color' => 'from-blue-400 to-blue-600',
                'timestamp' => '2020-08-10 09:03 AM',
                'content' => 'Live SIMPLY Dream BIG Be GREATFULL Give LOVE Laugh LOT.......',
                'likes' => 2,
                'comments' => 0,
                'shares' => 0,
                'image' => null
            ],
            [
                'id' => 2,
                'user_name' => 'Sania Shaheen',
                'profile_pic' => 'S',
                'profile_color' => 'from-yellow-400 to-yellow-600',
                'timestamp' => '2020-08-10 09:08 AM',
                'content' => 'World Championship: What makes the perfect snooker player? "Mark Selby": "You need to be mentally strong and have a good technique." "John Higgins": "Consistency and practice are key to success."',
                'likes' => 1,
                'comments' => 0,
                'shares' => 0,
                'image' => null,
                'has_read_more' => true
            ],
            [
                'id' => 5,
                'user_name' => 'John Smith',
                'profile_pic' => 'J',
                'profile_color' => 'from-green-400 to-green-600',
                'timestamp' => '2020-08-09 03:45 PM',
                'content' => 'Great team meeting today! Really excited about the new project we\'re starting next week. Looking forward to working with everyone!',
                'likes' => 1,
                'comments' => 0,
                'shares' => 0,
                'image' => null
            ],
            [
                'id' => 1,
                'user_name' => 'manda akhil user',
                'profile_pic' => 'M',
                'profile_color' => 'from-purple-400 to-purple-600',
                'timestamp' => '2020-08-10 09:08 AM',
                'content' => 'Hi All: Linda has been blessed with a baby boy! Linda: With love, we welcome your dear new baby to this world. Congratulations!',
                'likes' => 0,
                'comments' => 0,
                'shares' => 0,
                'image' => null
            ],
        ];

        // Most Commented Posts (sorted by comments)
        $commentedPosts = [
            [
                'id' => 6,
                'user_name' => 'Sarah Johnson',
                'profile_pic' => 'S',
                'profile_color' => 'from-indigo-400 to-indigo-600',
                'timestamp' => '2020-08-09 11:20 AM',
                'content' => 'What are your thoughts on remote work? Do you prefer working from home or coming to the office? Let\'s discuss!',
                'likes' => 0,
                'comments' => 3,
                'shares' => 0,
                'image' => null
            ],
            [
                'id' => 7,
                'user_name' => 'Michael Chen',
                'profile_pic' => 'M',
                'profile_color' => 'from-teal-400 to-teal-600',
                'timestamp' => '2020-08-08 02:15 PM',
                'content' => 'Just finished reading an amazing book on leadership. Highly recommend it to all managers out there! What books have inspired you recently?',
                'likes' => 0,
                'comments' => 2,
                'shares' => 0,
                'image' => null
            ],
            [
                'id' => 2,
                'user_name' => 'Sania Shaheen',
                'profile_pic' => 'S',
                'profile_color' => 'from-yellow-400 to-yellow-600',
                'timestamp' => '2020-08-10 09:08 AM',
                'content' => 'World Championship: What makes the perfect snooker player? "Mark Selby": "You need to be mentally strong and have a good technique." "John Higgins": "Consistency and practice are key to success."',
                'likes' => 1,
                'comments' => 0,
                'shares' => 0,
                'image' => null,
                'has_read_more' => true
            ],
            [
                'id' => 8,
                'user_name' => 'Emma Wilson',
                'profile_pic' => 'E',
                'profile_color' => 'from-red-400 to-red-600',
                'timestamp' => '2020-08-07 10:30 AM',
                'content' => 'Team lunch was fantastic! Thanks everyone for the great conversation and delicious food. Looking forward to our next gathering!',
                'likes' => 0,
                'comments' => 1,
                'shares' => 0,
                'image' => null
            ],
        ];

        // Select posts based on active tab
        $posts = match($tab) {
            'liked' => $likedPosts,
            'commented' => $commentedPosts,
            default => $recentPosts,
        };

        return view('buzz.buzz', compact('posts', 'tab'));
    }
}
