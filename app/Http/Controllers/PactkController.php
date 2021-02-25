<?php

// Party
// Holidays
// Wedding
// Babies & Kids
// Announcements


// Instagram Post
// Youtube Thumbnail
// Flyer
// Animated Social Media
// Facebook Post
// Presentation
// Invitation
// Ticket
// Instagram Story
// Poster
// Video
// Logo
// Infographic
// Facebook Cover
// Card
// Brochure
// Photo Collage
// Resume
// Business Card
// Blog Banner
// Youtube Channel Art
// Book Cover
// Desktop Wallpaper
// Certificate
// Menu
// Letterhead
// CD Cover
// ID Card
// Newsletter
// Calendar
// Postcard
// Label
// Announcement
// Gift Certificate
// Tag
// Program
// Bookmark
// Class Schedule
// Coupon
// Report
// Proposal
// Media Kit
// Worksheet
// Invoice
// Recipe Card
// Rack Card
// Planner
// Report Card
// Letter
// Lesson Plan

namespace App\Http\Controllers;

use Dompdf\Dompdf;

use SVG\SVG;
// use Image;
// use Intervention\Image\ImageManagerStatic as Image;

use SVG\Nodes\Shapes\SVGCircle;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;

use Barryvdh\DomPDF\Facade as PDF;
// use Image;
// use Intervention\Image;


ini_set('memory_limit', -1);


class PactkController extends Controller
{
	
}
