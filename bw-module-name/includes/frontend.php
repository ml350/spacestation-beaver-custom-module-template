<?php
// Start out by getting the posts
$posts = get_posts([
    'post_type' => 'team_member',
    'post_status' => 'publish',
    'numberposts' => -1
]);

// write code magic here