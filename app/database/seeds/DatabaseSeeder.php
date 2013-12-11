<?php

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        //$this->call('UsersTableSeeder');
        //$this->call('PermissionsTableSeeder');
        //$this->call('RolesTableSeeder');
        $this->call('LocationsTableSeeder');
        $this->call('ActivitiesTableSeeder');
        $this->call('LessonDateTemplatesTableSeeder');
        //$this->call('LessonsTableSeeder');
        //$this->call('MapsTableSeeder');
    }

}

/*

class MapsTableSeeder extends Seeder
{
    public function geocode($query)
   
{
        $placeSearchURL = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $query . '&sensor=false';

        $placeSearchJSON = file_get_contents($placeSearchURL);
        $dataArray = json_decode($placeSearchJSON);
        $location = $dataArray->results[0]->geometry->location;
        return array($location->lat, $location->lng);
    }
    
    public function run()
   
{
        $now = date('Y-m-d H:i:s');
        $locations = Location::all();
        
        foreach($locations as $location)
{
            $address = urlencode($location['address'] . $location['city'] . $location['state']);
            $latlng = self::geocode($address);

            Maps::create(array(
                    'id' => $location['id'],
                    'latitude' => $latlng[0],
                    'longitude' => $latlng[1],
                    )
            );
        }
    }
}

*/

class LessonsTableSeeder extends Seeder
{
    public function run()
    {

        for($i = 1; $i < 11; $i++) {
            $data = [
                'property' => 'grade',
                'comparison' => '=',
                'value' => $i,
            ];

            $restriction = LessonRestriction::create($data);
        }

        $now = date('Y-m-d H:i:s');
        for ($i=0; $i < 40; $i++) { 
            $data = [
                'section_id'    => mt_rand(5,10),
                'spots'         => mt_rand(15,30),
                'price'         => mt_rand(139,160)+.99,
                'session_id'    => 'WINTER2013',
                'provider'      => 'PAL',
                'active'        => 1,
                'created_at'    => $now,
                'updated_at'    => $now
            ];

            Lesson::create($data);
            $lesson = Lesson::find($i+1);

            $location = Location::find(mt_rand(1,12));
            $location->lessons()->save($lesson);

            $activity = $location->activities()->first();
            $activity->lessons()->save($lesson);

            for ($j=0; $j < mt_rand(2,5); $j++) { 
                $restriction = LessonRestriction::find(mt_rand(1,10));
                $lesson->restrictions()->attach($restriction);
            }

            $lessons            = [];
            $lesson_start       = date('j') + mt_rand(-60, 60);
            $lesson_time        = mt_rand(12,20);
            $current_lesson     = mktime($lesson_time, 0, 0, date('m'), $lesson_start, date('Y'));
            $current_lesson_end = mktime($lesson_time+1, 0, 0, date('m'), date('j', $current_lesson));

            for($j = 0; $j < 9; $j++) {                
                $lesson_date = new LessonDate;
                $lesson_date->starts_on = date('Y-m-d H:i:s', $current_lesson);
                $lesson_date->ends_on   = date('Y-m-d H:i:s', $current_lesson_end);
                $lesson_date->created_at = $now;
                $lesson_date->updated_at = $now;
                $lesson_date->save();

                $lesson_date->lesson()->associate($lesson);
                
                if ($j === 8) {
                    $t = LessonDateTemplate::find(7);
                    $t->lesson_dates()->save($lesson_date);
                } else {
                    $t = LessonDateTemplate::find(8);
                    $t->lesson_dates()->save($lesson_date);
                }

                $current_lesson = mktime($lesson_time, 0, 0, date('m', $current_lesson), date('j', $current_lesson)+7);
                $current_lesson_end = mktime($lesson_time+1, 0, 0, date('m', $current_lesson), date('j', $current_lesson));
            }
        }
    }
}

class ActivitiesTableSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $activities = [
            [
                'name' => 'Tennis'
            ],
            [
                'name' => 'Art'
            ],
        ];

        foreach ($activities as $activity) {
            $instance = Activity::create($activity);
        }

        $instance = Activity::find(1);
        $locations = Location::where('id', '<', 12)->get();
        foreach ($locations as $location) {
            $instance->locations()->attach($location);
        }

        $instance = Activity::find(2);
        $location = Location::find(12);
        $instance->locations()->attach($location);
    }
}

class LessonDateTemplatesTableSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $templates = [
            [
                'name' => 'Courtesy Sign Up',
                'description' => 'Enrolled students have a chance to re-enroll before open sign up.',
                'stackable' => 1,
                'has_many' => 0,
            ],
            [
                'name' => 'Open Sign Up',
                'description' => 'Any student may sign up.',
                'stackable' => 1,
                'has_many' => 0,
            ],
            [
                'name' => 'Late Sign Up',
                'description' => 'Any student may sign up, but the session has begun.',
                'stackable' => 1,
                'has_many' => 0,
            ],
            [
                'name' => 'Snow Day',
                'description' => 'Class is cancelled due to inclement weather.',
                'stackable' => 0,
                'has_many' => 1,
            ],
            [
                'name' => 'No Class',
                'description' => 'Class is cancelled.',
                'stackable' => 0,
                'has_many' => 1,
            ],
            [
                'name' => 'Holiday',
                'description' => 'Class is cancelled for the holiday.',
                'stackable' => 0,
                'has_many' => 1,
            ],
            [
                'name' => 'Make-up Lesson',
                'description' => 'Make-up for a cancelled lesson.',
                'stackable' => 0,
                'has_many' => 1,
            ],
            [
                'name' => 'Lesson',
                'description' => 'Scheduled class.',
                'stackable' => 0,
                'has_many' => 1,
            ]
        ];

        foreach ($templates as $template) {
            LessonDateTemplate::create($template);
        }
    }
}

class LocationsTableSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $locations = array(
                           array(
                                 'name' => 'Sportime Massapequa',
                                 'contact_name' => 'Fayez',
                                 'phone' => '5167993550',
                                 'address' => '5600 Old Sunrise Highway',
                                 'city' => 'Massapequa',
                                 'state' => 'NY',
                                 'zip_code' => '11758',
                                 'capacity' => 8,
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Bethpage Park Tennis Center',
                                 'contact_name' => 'Andrea, Steve',
                                 'phone' => '5137771358',
                                 'address' => '99 Quaker Meeting House Road',
                                 'city' => 'Farmingdale',
                                 'state' => 'NY',
                                 'zip_code' => '11735',
                                 'capacity' => 8,
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Long Beach Tennis Center',
                                 'contact_name' => 'Sid, Sunil',
                                 'phone' => '5164326060',
                                 'address' => '899 Monroe Boulevard',
                                 'city' => 'Long Beach',
                                 'state' => 'NY',
                                 'zip_code' => '11561',
                                 'capacity' => 8,
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Eastern Athletic Club',
                                 'contact_name' => 'Kristin, Cira',
                                 'phone' => '6314642882',
                                 'address' => '9A Montauk Highway',
                                 'city' => 'Blue Point',
                                 'state' => 'NY',
                                 'zip_code' => '11715',
                                 'capacity' => 6,
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Eastern Athletic Club',
                                 'contact_name' => 'Marc, Jamie',
                                 'phone' => '6314201310',
                                 'address' => '100 Ruland Road',
                                 'city' => 'Melville',
                                 'state' => 'NY',
                                 'capacity' => 6,
                                 'zip_code' => '11747',
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Eastern Athletic Club',
                                 'contact_name' => 'Sheldon, Betsy',
                                 'phone' => '6312716616',
                                 'address' => '854 East Jericho Turnpike',
                                 'city' => 'Dix Hills',
                                 'state' => 'NY',
                                 'capacity' => 6,
                                 'zip_code' => '11746',
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Sportime Kings Park',
                                 'contact_name' => 'Jason, Joe, Will',
                                 'phone' => '6312696300',
                                 'address' => '275 Old Indian Head Road',
                                 'city' => 'Kings Park',
                                 'state' => 'NY',
                                 'capacity' => 8,
                                 'zip_code' => '11754',
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Sportime Quogue',
                                 'contact_name' => 'Mark, Jeannie',
                                 'phone' => '6316536767',
                                 'address' => '2571 Quogue-Riverhead Road',
                                 'city' => 'East Quogue',
                                 'state' => 'NY',
                                 'capacity' => 8,
                                 'zip_code' => '11942',
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Bay Terrace Tennis Center',
                                 'contact_name' => 'Sunil',
                                 'phone' => '7182295151',
                                 'address' => '212-00 23rd Avenue',
                                 'city' => 'Bayside',
                                 'state' => 'NY',
                                 'zip_code' => '11360',
                                 'capacity' => 0,
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Jericho Westbury Indoor Tennis',
                                 'contact_name' => 'Don, Laura',
                                 'phone' => '5169974060',
                                 'address' => '44 Jericho Turnpike',
                                 'city' => 'Jericho',
                                 'state' => 'NY',
                                 'zip_code' => '11753',
                                 'capacity' => 0,
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'West Hampton Beach',
                                 'contact_name' => 'Bobby Lum',
                                 'phone' => '6312886060',
                                 'address' => '86 Depot Road',
                                 'city' => 'West Hampton Beach',
                                 'state' => 'NY',
                                 'zip_code' => '11978',
                                 'capacity' => 8,
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           array(
                                 'name' => 'Studio Art Commack',
                                 'contact_name' => 'Karen Hogan',
                                 'phone' => '9736700572',
                                 'address' => '213 Commck Road',
                                 'city' => 'Commack',
                                 'state' => 'NY',
                                 'zip_code' => '11725',
                                 'capacity' => 0,
                                 'status' => 1,
                                 'notes' => NULL,
                                 ),
                           );

        foreach($locations as $location) {
            Location::create($location);
        }

    }
}

/*

class RolesTableSeeder extends Seeder
{
    public function run()
   
{
        $now = date('Y-m-d H:i:s');

        $role = new Role;
        $role->name = 'admin';
        $role->save();

        $role = Role::find(1);
        for($i = 1; $i < 50; $i++)
{
            $role->permissions()->attach($i);
        }
        $role->users()->attach(1);
        $role->save();
        
        $user = User::find(1);
        $user->roles()->attach(1);
        $user->save();
    }
}

class PermissionsTableSeeder extends Seeder
{
    public function run()
   
{
        $now = date('Y-m-d H:i:s');

        $resources = array('permissions', 'locations', 'classes', 'users', 'activities', 'permissions', 'roles');
        $actions = array('index', 'create', 'store', 'edit', 'update', 'destroy', 'show');

        foreach($resources as $resource)
{
            foreach($actions as $action)
{
                Permission::create(array(
                                         'resource' => $resource,
                                         'action'   => $action,
                                         'created_at' => $now,
                                         'updated_at' => $now,
                                         ));
            }
        }
    }
}

*/

class UsersTableSeeder extends Seeder
{
    public function run()
   {

        $now = date('Y-m-d H:i:s');
        $schools = ["Abbey Lane School","Aquebogue Elementary School","Academy Street Elementary School","Accompsett Elementary School","Accompsett Middle School","Albany Avenue Elementary School","Albany Avenue Elementary School","Alden Terrace School","Alleghany Avenue Elementary School","Alverta B. Gray Schultz Middle School","Amagansett School","Amityville Memorial High School","Andrew Muller Primary School","Andrew T. Morrow School","Archer Street School","Arrowhead Elementary School","Babylon Elementary School","Babylon High School","Babylon Memorial Grade School","Baldwin Middle School","Baldwin Senior High School","Barnum Woods Elementary School","Barton Elementary School","Bay Elementary School","Bay Shore High School","Bay Shore Middle School","Baylis Elementary School","Bayport-Blue Point High School","Bayview Avenue School For The Arts And Sciences","Bayview Elementary School","Bayville Elementary School","Beach Street Middle School","Bellerose Avenue Elementary School","Bellport High School","Bellport Middle School","Belmont Elementary School","Berner Middle School","Berry Hill Elementary School","Bethpage High School","Bicycle Path School","Birch Lane Elementary School","Birch School","Birchwood Intermediate School","Blackheath Road Pre-K Kindergarten Center","Blue Point Elementary School","Boces Suffolk Regional Information Center","Bowling Green School","Boyle Road Elementary School","Branch Brook Elementary School","Brentwood East Elementary School","Brentwood High School","Brentwood North Elementary School","Brentwood Northeast Elementary School","Bretton Woods Elementary School","Briarcliff Elementary School","Bridgehampton School","Bronx Preparatory Charter School","Brooke Avenue Elementary School","Brookhaven Annex","Brookhaven Elementary School","Brooklyn Avenue School","Brookside Elementary School","Burns Avenue School","Burr Intermediate School","C.E. Walters School","California Avenue School","Camp Avenue School","Canaan Elementary School","Candlewood Middle School","Cantiague Elementary School","Captree Elementary School","Carl C. Icahn Charter School","Carle Place Middle School\/High School","Caroline G. Atkinson School","Cayuga School","Centennial Avenue Elementary School","Center Moriches High School","Center Street Elementary School","Centereach High School","Central Boulevard Elementary School","Central Islip Early Childhood Center","Central Islip High School","Centre Avenue Elementary School","Charles A. Mulligan Intermediate School","Charles Campagne Elementary School","Chatterton School","Cherokee Street Elementary School","Cherry Avenue Elementary School","Cherry Lane School","Chestnut Hill Elementary School","Child Development Center Of The Hamptons Charter School","Chippewa Elementary School","Clara H. Carlson School","Clarke Middle School","Clayton Huey Elementary School","Clearstream Avenue School","Clinton Avenue School","Cold Spring Harbor High School","Columbus Avenue School","Commack High School","Commack Middle School","Commack Road Elementary School","Comsewogue High School","Connetquot Elementary School","Connetquot High School","Connolly School","Copiague Middle School","Coram Elementary School","Cordello Avenue Elementary School","Cornwell Avenue School","Countrywood Primary Center","Covert Avenue School","Cross Street School","Daniel Street Elementary School","Davison Avenue Elementary School","Dawnwood Middle School","Dayton Avenue Elementary School","Deasy School","Deauville Gardens Elementary School","Deer Park High School","Denton Avenue School","Dickinson Avenue Elementary School","Division Avenue High School","Dogwood Elementary School","Drexel Avenue School","Dryden Street School","Dutch Broadway School","Dutch Lane School","Eagle Elementary School","Early Childhood Center","East Broadway School","East Elementary School","East Hampton High School","East Hampton Middle School","East Hills School","East Islip High School","East Islip Middle School","East Lake Elementary School","East Meadow High School","East Middle School","East Moriches Middle School","East Northport Middle School","East Quogue Elementary School","East Rockaway High School","East Street School","Eastplain School","Eastport Elementary School","Eastport School","Edith L. Slocum Elementary School","Edmund W. Miles Middle School","Edna Louise Elementary School","Edward J. Bosti Elementary School","Edward W. Bower Elementary School","Eearl L. Vandermeulen Port Jeff High School","Elizabeth Mellick Baker School","Elmont Memorial High School","Elmont Pre-Kindergarten (Pre-K)","Elwood Middle School","Elwood-John H. Glenn High School","Eugene Auer Memorial School","Fairfield Elementary School","Farmingdale High School","Fifth Avenue Elementary School","Fifth Avenue School","Finley Middle School","Fishers Island School","Floral Park - Bellerose School","Floral Park Memorial High School","Florence A. Smith Elementary School #2","Flower Hill School","Floyd B. Watson School","Forest Avenue Elementary School","Forest Brook Elementary School","Forest Lake Elementary School","Forest Park Elementary School","Forest Road School","Fork Lane School","Fort Salonga Elementary School","Francis F. Wilson School","Francis J. O'neill School","Francis X. Hegarty Elementary School","Frank J. Carasiti Elementary School","Frank P. Long Intermediate School","Franklin Early Childhood Center","Franklin School","Freeport High School","Freshman Center","Fulton Avenue School #8","Fulton Elementary School","Garden City High School","Garden City Middle School","Garden City Park School","Gardiner Manor School","Gardiners Avenue School","Gatelot Avenue School","George A. Jackson School","George W. Hewlett High School","George Washington Elementary School","Glen Cove High School","Glen Cove Middle School","Glen Head Elementary School","Glenwood Landing Elementary School","Goosehill Primary School","Gotham Avenue School","Grand Avenue Middle School","Grand Avenue School","Great Hollow Middle School","Great Neck North High School","Great Neck North Middle School","Great Neck Road Elementary School","Great Neck South High School","Great Neck South Middle School","Greenport Elementary School","Greenport High School","Gribbin School","Grundy Avenue School","Guggenheim Elementary School","H. Frank Carey High School","H.B. Thompson Middle School","Half Hollow Hills High School East","Half Hollow Hills High School West","Hampton Bays Elementary School","Hampton Bays Secondary School","Hampton Street School","Harbor Hill School","Harborfields High School","Harding Avenue Elementary School","Harley Ave Primary Elementary School","Harold D. Fayette Elementary School","Harriet Tubman Charter School","Harry D. Daniels School","Hauppauge High School","Hauppauge Middle School","Hawkins Path Elementary School","Helen B. Duffield Elementary School","Hemlock Park Elementary School","Hemlock School","Hempstead Early Childhood Center","Hempstead High School","Hempstead Pre-Kindergarten","Henry L. Stimson Middle School","Herricks High School","Herricks Middle School","Hewlett Elementary School","Hiawatha School","Hicksville High School","Hicksville Middle School","Hillside Grade School","Holbrook Road School","Homestead School","Howard B. Mattlin Middle School","Howard T. Herber Middle School","Howell Road School","Huntington High School","Huntington Intermediate School","Idle Hour Elementary School","Indian Hollow School","International Charter High School At Laguardia","Island Park Lincoln Orens Middle School (Loms)","Island Trees High School","Island Trees Middle School","Islip High School","Islip Middle School","J. Fred Sparke Elementary School","J. W. Dodd Middle School","Jackson Annex School","Jackson Avenue School","Jackson Main Elementary School","Jacob Gunther Elementary School","James A. Dever Elementary School","James H. Boyd Intermediate School","James H. Vernon School","James Wilson Young Middle School","Jefferson Primary School","Jennie E. Hewitt Elementary School","Jericho Elementary School","Jericho High School","Jericho Middle School","Jfk Middle School","John F. Kennedy Elementary School","John F. Kennedy Elementary School","John F. Kennedy High School","John F. Kennedy Intermediate School","John F. Kennedy Middle School","John F. Kennedy School","John G. Dinkelmeyer Elementary School","John H. West Elementary School","John J. Daly Elementary School","John Lewis Childs School","John M Marshall Elementary School","John Pearl Elementary School","John Quincy Adams Elementary School","John S. Hobart Elementary School","John Street School","Jonas E. Salk Middle School","Joseph A. Edgar Elementary School","Kindergarten Center At Atlantic Avenue","Kings Park High School","Kipp Acadamy Charter School","Kramer Lane Elementary School","Kreamer Street Elementary School","Laddie A. Decker Sound Beach School","Lakeville School","Landing School","Laurel Park Elementary School","Lawrence High School","Lawrence Middle School","Lawrence Road Middle School","Lee Avenue School","Lee Road School","Lenox Elementary School","Leo. F. Giblyn School","Levittown Memorial Spec Education Center","Lido Elementary School","Lincoln Avenue Elementary School","Lincoln School","Lindell Blvd School","Lindenhurst High School","Lindenhurst Middle School","Little Flower School","Lloyd Harbor School","Lockhart Elementary School","Locust School","Locust Valley Elementary School","Locust Valley High School","Locust Valley Middle School","Long Beach High School","Long Beach Middle School","Longwood High School","Longwood Junior High School","Longwood Middle School","Loretta Park Elementary School","Ludlum Elementary School","Lynbrook High School","Lynbrook North Middle School","Lynbrook South Middle School","Lynwood Avenue School","Macarthur High School","Malverne High School","Mandalay Elementary School","Manetuck Elementary School","Manhasset High School","Manhasset Middle School","Manor Oaks School","Manorhaven Elementary School","Maplewood Intermediate School","Margurite L. Mulvey School","Marion G. Vedder Elementary School","Marion Street Elementary School","Marshall Kindergarten Center","Martin Luther King Elementary School","Mary G. Clarkson School","Massapequa High School","Massapequa High School - Ames Campus","Mattituck Jr\/Sr High School","Mattituck-Cutchogue East Elementary School","Maud S. Sherwood Elementary School","Maurice W. Downing School","May Moore Elementary School","Mckenna Elementary School","Mcvey Elementary School","Meadow Drive School","Meadow Elementary School","Meadowbrook Elementary School","Medford Elementary School","Merrick Academy - Queens Charter School","Merrick Avenue Middle School","Merrimac Elementary School","Michael F. Stokes Elementary School","Middle College High School","Milburn Elementary School","Miller Avenue School","Miller Place High School","Milton L. Olive Middle School","Mineola High School","Mineola Middle School","Minnesauke Elementary School","Montauk School","Moriches Elementary School","Mount Pleasant Elementary School","Mount Sinai Elementary School","Mount Sinai High School","Mount Sinai Middle School","Munsey Park Elementary School","Nassakeag Elementary School","Nassau Boces","Nathaniel Woodhull School","Nesconset Elementary School","New Hyde Park Memorial High School","New Hyde Park Road School","New Lane Memorial Elementary School","New Suffolk School","New Visions Elementary School","Newbridge Road School","Newfield High School","Nokomis School","Norman J. Levy Lake Elementary School","North Babylon High School","North Coleman Road School","North Country Road School","North Middle School","North Oceanside Road School #5","North Ridge School","North Shore High School","North Shore Middle School","North Side School","Northeast Elementary School","Northedge School","Northern Parkway School","Northport High School","Northport Middle School","Northside Elementary School","Northside School","Northwest Elementary School","Norwood Avenue School","Norwood Avenue School (Pjs)","Number Five School","Number Four School","Number One School","Number Six School","Number Two School","Oak Park Elementary School","Oakdale Bohemia Junior High School","Oaks School #3","Oakwood Primary Center","Ocean Avenue School","Oceanside High School","Oceanside Middle School","Ogden Elementary School","Old Bethpage Elementary School","Old Country Road School","Old Mill Road Elementary School","Oldfield Middle School","Oquenock Elementary School","Oregon Middle School","Otsego Elementary School","Our World Neighborhood Charter","Oxhead Road Elementary School","Oyster Bay High School","Oysterponds Elementary School","Park Avenue Memorial Elementary School","Park Avenue School","Park Avenue School - North Bellmore","Park View Elementary School","Parkville School Early Childhood Center","Parkway Elementary School","Parkway School","Parliament Place Elementary School","Pasadena Elementary School","Patchogue - Medford High School","Paul D. Schreiber High School","Paul J. Bellew Elementary School","Paul J. Gelinas Junior High School","Paumanok Elementary School","Phillips Avenue School","Pierson High School","Pine Park Elementary School","Pines Elementary School","Plainedge High School","Plainedge Middle School","Plainview - Old Bethpage Kindergarten Center","Plainview-Old Bethpage John F. Kennedy High School","Plainview-Old Bethpage Middle School","Plaza Elementary School","Polk Street School","Port Jefferson Middle School","Powells Lane School","Pre K And Kindergarten Center (School #6)","Pre-K School","Prodell Middle School","Pulaski Road School","Pulaski Street Elementary School","Quogue School","R. J. O. Intermediate School","R.C. Murphy Junior High School","Ralph Reed School","Reinhard Early Chldhood Center","Remsenburg-Speonk Elementary School","Renaissance Charter School","Rhame Avenue School","Ridge Elementary School","Riley Avenue School","River Elementary School","Riverhead Charter School","Riverhead High School","Riverhead Middle School","Riverside School","Roanoke Avenue School","Robbins Lane Elementary School","Robert Frost Middle School","Robert Moses Middle School","Robert Seaman Elementary School","Robert W. Carbonaro School","Rocky Point High School","Rolling Hills School","Ronkonkoma Junior High School","Roosevelt Childrens Acadamy","Roosevelt High School","Roslyn Heights Elementary School","Roslyn High School","Roslyn Middle School","Rushmore Avenue School","Ruth C. Kinney Elementary School","Sachem High School","Saddle Rock School","Sag Harbor Elementary School","Sagamore Middle School","Sagaponack School","Saltzman East Memorial School","San Remo Alternative School","Sanford H. Calhoun High School","Santapogue School","Saw Mill Road Elementary School","Sawmill Intermediate School","Saxton Middle School","Sayville High School","Sayville Middle School","Schwarting Elementary School","Sea Cliff Elementary School","Seaford Harbor School","Seaford High School","Seaford Manor School","Seaford Middle School","Searingtown School","Selden Middle School","Seneca Middle School","Setauket Elementary School","Sewanhaka High School","Shaw Avenue School","Shelter Island School","Shelter Rock Elementary School","Shore Road Intermediate Center","Shoreham-Wading River High School","Shubert Elementary School","Signal Hill Elementary School","Smith Street School","Smithtown Elementary School","Smithtown High School","Smithtown Middle School","Sousa Elementary School","South Bay Elementary School","South Country School","South Grove Elementary School","South Middle School","South Ocean Middle School","South Oceanside Road Elementary School #4","South Side High School","South Side Middle School","South Street Elementary School","South Woods Middle School","Southampton Elementary School","Southampton High School","Southampton Intermediate School","Southdown Primary School","Southeast Elementary School","Southold Elementary School","Southold High School","Southwest Elementary School","Springs School","St. James Elementary School","Stagecoach Elementary School","Steele Elementary School","Stewart Manor Elementary School","Stewart School","Stratford Ave School","Stratford Road Elementary School","Sullivan Charter School","Summit Lane School","Sunquam Elementary School","Sunrise Drive Elementary School","Susan E. Wiley School","Sycamore Avenue Elementary School","Sylvan Ave Elementary School","Syosset Senior High School","Tackan Elementary School","Tamarac Elementary School","Tangier Smith School","Tecumseh Elementary School","Terryville Elementary School","Theodore Roosevelt Elementary School","Thomas J. Lahey Elementary School","Timber Point Elementary School","Tooker Avenue School","Tremont Elementary School","Tuckahoe School","Turtle Hook Middle School","Twin Pines Elementary School","Udall Road Middle School","Ulyss Elementary School","Uniondale High School","Unity Drive Learning Center - Kindergarten","Unqua Elementary School","Valley Stream Central High School","Valley Stream Memorial Junior High School","Valley Stream North High School","Valley Stream South High School","Vanderbilt Elementary School","Verne W. Critz Elementary School","Village Elementary School","Village School","W. Tresper Clarke High School","Wading River Elementary School","Wainscott School","Walnut Street School","Walt Whitman Elementary School","Walt Whitman High School","Walter G. O'connell High School","Walter S. Boardman Elementary School","Wantagh Elementary School","Wantagh High School","Wantagh Middle School","Ward Melville High School","Washington Drive Primary School","Washington Primary School","Washington Rose School","Washington Street School","Waverly Avenue School","Waverly Park Elementary School","Weber Middle School","Weldon E. Howitt Middle School","Wellington C. Mepham High School","Wenonah School","West Babylon Junion High School","West Babylon Senior High School","West Elementary School","West End Elementary School","West Gates Elementary School","West Hempstead High School","West Hempstead Middle School","West Hollow Middle School","West Islip High School","West Middle Island Elementary School","West Middle School","West Side School","Westbrook Elementary School","Westbury High School","Westbury Middle School","Western Suffolk Boces","Westhampton Beach Elementary School","Westhampton Beach High School","Westhampton Beach Middle School","Wheatley School","Wheeler Avenue School","Willets Road School","William E. Deluca Jr. Elementary School","William Floyd Elementary School","William Floyd High School","William L. Buck School","William Paca Middle School","William Rall Elementary School","William S. Covert School","William Sidney Mt. School","William T. Rogers Middle School","Willits Elementary School","Willow Road School","Wing Elementary School","Winthrop Avenue Primary Center","Wisdom Lane Middle School","Wood Park School","Woodhull Intermediate School","Woodhull School","Woodland Avenue School","Woodland Middle School","Woodmere Middle School","Woods Road Elementary School","Woodward Parkway School","Wyandanch Memorial High School"];
        $names = array(
                       'James',
                       'Mary',
                       'Ruthie',
                       'William',
                       'Timmy',
                       'Heidi',
                       'Craig',
                       'Ryan',
                       'Danny',
                       'Jordan',
                       'John',
                       'Betsy',
                       'Clementine',
                       'Nostrodamus',
                       'Daniel',
                       'David',
                       'Nancy',
                       'Claire',
                       'Simmons',
                       'Williams',
                       'Bernie',
                       'Clements',
                       'Tabbitha',
                       'George',
                       'Brock',
                       'Leslie',
                       );


        $users = array(
                        array(
                              'email' => 'admin',
                              'password' => Hash::make('admin'),
                              'phone' => '',
                              'first_name' => '',
                              'last_name' => 'Admin',
                              'address' => '',
                              'city' => '',
                              'state' => '',
                              'zip_code' => '',
                              'remember' => 1,
                              'status' => 1,
                              'created_at' => $now,
                              'updated_at' => $now
                              ),
                        );

        $children = [];

        for($i = 0; $i < 10; $i++) {
            $first_name = $names[array_rand($names)];
            $last_name = $names[array_rand($names)];
            $email = strtolower($first_name.''.$last_name).'@example.com';

            $data = array(
                             'email' => $email,
                             'password' => Hash::make($email),
                             'phone' => '5555555555',
                             'first_name' => $first_name,
                             'last_name' => $last_name,
                             'address' => '555 Example Road',
                             'city' => 'Example City',
                             'state' => 'NY',
                             'zip_code' => '55555',
                             'remember' => 1,
                             'status' => 1,
                             'created_at' => $now,
                             'updated_at' => $now
                             );

            $user = User::create($data);

            for($j = 0; $j < mt_rand(1,4); $j++) {
                $child_first_name = $names[array_rand($names)];
                $month = mt_rand(1,12);
                $day = mt_rand(1,31);
                $year = mt_rand(1994,2008);

                $birthday = date('Y-m-d H:i:s', mktime(0,0,0,$month,$day,$year));
                $data = [
                    'first_name'    => $child_first_name,
                    'last_name'     => $last_name,
                    'school'        => $schools[mt_rand(0,count($schools))],
                    'birthday'      => $birthday,
                    'age'           => Child::getAge($month.'/'.$day.'/'.$year),
                    'grade'         => mt_rand(1,12),
                    'gender'        => 'male',
                    'returning_player' => 0,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];

                $child = Child::create($data);
                $user->children()->save($child);
            }
        }
    }
}
