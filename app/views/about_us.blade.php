@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'About Us', 'icon' => 'briefcase', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'About Us'])
<div class="box bg-1">
	<div class="box measure bg-0 border-left border-bottom-0">
		@include('modules.section_divide', ['name' => 'Contents'])
		<ul class="box box-pad-4 bg-0 border-bottom-0">
			<li><a href="#TennisLessons">Tennis Lessons</a></li>
			<li><a href="#TennisPros">Tennis Pros</a></li>
			<li><a href="#TennisLocations">Tennis Locations</a></li>
			<li><a href="#CreativeArtsClub">Creative Arts Club</a></li>
			<li><a href="#ArtsStaff">Arts Staff</a></li>
			<li><a href="#ArtsStudio">Arts Studio</a></li>
			<li><a href="#SpecialNeedsPrograms">Special Needs Programs</a></li>
		</ul>
		<div id="TennisLessons"></div>
		@include('modules.section_divide', ['name' => 'Tennis Lessons'])
		<div class="box box-pad-0 bg-0 border-bottom-0">After school programs provides an inexpensive alternative to otherwise costly sport lessons through creative class design and implementation. Our classes have more players per pro, but what is given up slightly in individual focus, is more than made up for in cooperative instruction, drills and group play.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">The atmosphere is lively and fun, and this non-competitive environment makes for fertile ground for maximizing good experiences, making new friends, and most of all, creating a desire to continue with the sport.</div>
		<div id="TennisPros"></div>
		@include('modules.section_divide', ['name' => 'Tennis Pros'])
		<div class="box box-pad-0 bg-0 border-bottom-0">The tennis pros for our programs are the house pros at the clubs. USPTA or USPTR certified professionals, these pros teach year round and combined, have 1000’s of hours of experience behind them, having worked with players from pre-K to adult (and beyond !) They are the backbone of our programs, whose experience and creativity help make the classes the great experience that it is.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">Parents can always speak to their pros about their child’s progress in the class, ask for racquet recommendations, or anything else that may want to discuss.</div>
		<div id="TennisLocations"></div>
		@include('modules.section_divide', ['name' => 'Tennis Locations'])
		<div class="box box-pad-0 bg-0 border-bottom-0">All programs run throughout the school year and take place at facilities housing indoor courts. The facilities have excellent off-court viewing accommodations for parents who can watch their child play and learn. Additional club facilities, such as exercise equipment are not available for use to our parents, as you need to be a member to take advantage of these accommodations.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">Our locations are centrally located for easy access, by parkway, expressway, or highway. Refer to our map for more info on how to reach your facility.</div>
		<div id="CreativeArtsClub"></div>
		@include('modules.section_divide', ['name' => 'Creative Arts Club'])
		<div class="box box-pad-0 bg-0 border-bottom-0">Design, construct, enhance, explore! Your child will have ample opportunity to tap their own creativity and create projects:</div>
		<ul class="box box-pad-4 bg-0 border-bottom-0">
			<li>Projects include Creative Arts Club</li>
			<li>Hand building with Clay</li>
			<li>Dabble in Decoupage</li>
			<li>"Up" cycled art</li>
			<li>Mixed Media Canvas-"All about Me"</li>
			<li>Duck/Duct tape Mania</li>
			<li>Crazy Concoctions</li>
			<li>Drawing with Dimension</li>
			<li>"Scent" sational soap making</li>
			<li>Plaster of Paris Creations using molds</li>
			<li>Textile Designs (tie-dye/Batik)</li>
			<li>Abstract Art with eggshells</li>
			<li>and more!</li>
		</ul>
		<div class="box box-pad-0 bg-0 border-bottom-0">Not all projects can be done in one 8 week session.</div>
		<div id="ArtsStaff"></div>
		@include('modules.section_divide', ['name' => 'Arts Staff'])
		<div class="box box-pad-0 bg-0 border-bottom-0">Karen Hogan, a certified educator, heads up the Creative Arts Club team. In addition to this program, she runs programs for Ramaz school, Raynor Country Day School, the enrichment program for Remsenburg school district. Between two to four high school students comprise the assisting staff for each class.</div>
		<div id="ArtsStudio"></div>
		@include('modules.section_divide', ['name' => 'Arts Studio'])
		<div class="box box-pad-0 bg-0 border-bottom-0">Our Westhampton beach facility enjoys all the markings of a true bohemian art studio, complete with paint stained work tables, colorful storage walls, and painted handprints of every student who has ever graced these premises, everywhere you look. It is a perfect environment for children of all ages to let go and be creative.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">The studio is located just north of the center of town at 22 Sunset Ave, which can be accessed from Montauk hwy as well.</div>
		<div id="SpecialNeedsPrograms"></div>
		@include('modules.section_divide', ['name' => 'Special Needs Programs'])
		<div class="box box-pad-0 bg-0 border-bottom-0">Our Special Needs programs are geared for individuals with developmental challenges. All programs are supervised by certified professionals in their respective fields, and all have training to work with this population.</div>
		@include('modules.section_divide', ['name' => 'Tennis'])
		<div class="box box-pad-0 bg-0 border-bottom-0">Our tennis program is set up in a safe, easy-to-succeed environment through the use of modified equipment to maximize success. Players have an opportunity to learn racquet control, eye-hand coordination, increase listening and interactive skills and increase socialization skills through on-court shadows that assist players as needed. Attainable goals are set up for all activities presented. Ages 8 – 18.</div>
		@include('modules.section_divide', ['name' => 'Art'])
		<div class="box box-pad-0 bg-0 border-bottom-0">Art is a natural for special needs. Through exposure to a variety of crafts projects, students draw, paint, sculpt, glue, and creatively enhance projects. Although we do have shadows, parents are encouraged to join in. Ages 5 – 18.</div>
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop
