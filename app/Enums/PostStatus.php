<?php

namespace App\Enums;

enum PostStatus: string
{
    case PUBLISHED = 'Published';
    case DRAFTED = 'Drafted';
}
