<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::table('college_course')->truncate();
        DB::table('colleges')->truncate();

        // Get some courses to attach
        $courses = Course::take(10)->get();
        $courseIds = $courses->pluck('id')->toArray();

        $colleges = [
            [
                'name' => 'Indian Institute of Technology Delhi',
                'slug' => 'iit-delhi-engineering-college',
                'short_description' => 'Premier engineering institute in India, ranked among top institutions',
                'description' => '<h2>About IIT Delhi</h2>
                <p>The Indian Institute of Technology Delhi is one of the 23 Indian Institutes of Technology created to be Centres of Excellence for training, research and development in science, engineering and technology in India.</p>
                
                <h3>Infrastructure</h3>
                <p>Spread over 320 acres, IIT Delhi has state-of-the-art laboratories, modern classrooms, extensive libraries, and excellent sports facilities.</p>
                
                <h3>Research Excellence</h3>
                <p>The institute is known for its research output in various fields including engineering, science, and technology.</p>',
                'address' => 'Hauz Khas',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'country' => 'India',
                'pincode' => '110016',
                'phone' => '01126591171',
                'email' => 'office@iitd.ac.in',
                'website' => 'https://home.iitd.ac.in',
                'latitude' => 28.5455,
                'longitude' => 77.1923,
                'established_year' => 1961,
                'accreditation' => 'A++ Grade by NAAC',
                'affiliation' => 'Autonomous',
                'type' => 'autonomous',
                'campus_size' => '320 acres',
                'total_students' => 8500,
                'total_faculty' => 650,
                'logo' => 'colleges/logo/iitd.png',
                'cover_image' => 'colleges/cover/iitd.jpg',
                'gallery_images' => [
                    'colleges/gallery/iitd1.jpg',
                    'colleges/gallery/iitd2.jpg',
                    'colleges/gallery/iitd3.jpg'
                ],
                'nirf_ranking' => 2,
                'rating' => 4.8,
                'review_count' => 245,
                'fees_structure' => [
                    'BTech' => 200000,
                    'MTech' => 150000,
                    'PhD' => 100000
                ],
                'admission_process' => 'Admission through JEE Advanced for BTech, GATE for MTech, and institute entrance tests for PhD programs.',
                'eligibility_criteria' => [
                    ['criteria' => 'JEE Advanced', 'description' => 'For BTech programs'],
                    ['criteria' => 'GATE Score', 'description' => 'For MTech programs'],
                    ['criteria' => 'Minimum 75%', 'description' => 'in 12th standard']
                ],
                'application_deadline' => '2024-05-31',
                'academic_year_start' => '2024-07-15',
                'facilities' => ['Library', 'Hostel', 'Sports Complex', 'Medical Center', 'Cafeteria', 'Wi-Fi Campus'],
                'average_package' => 1800000,
                'highest_package' => 4500000,
                'top_recruiters' => ['Google', 'Microsoft', 'Amazon', 'Goldman Sachs', 'McKinsey'],
                'placement_percentage' => 85,
                'meta_title' => 'IIT Delhi - Best Engineering College in India',
                'meta_description' => 'Indian Institute of Technology Delhi offers BTech, MTech, PhD programs with excellent placement records.',
                'meta_keywords' => 'iit delhi, engineering college, iit, technical education',
                'is_featured' => true,
                'status' => 'published',
                'views_count' => 12500
            ],

            [
                'name' => 'Delhi University',
                'slug' => 'delhi-university-arts-science',
                'short_description' => 'Premier central university offering diverse undergraduate and postgraduate programs',
                'description' => '<h2>About Delhi University</h2>
                <p>The University of Delhi is a collegiate public central university located in New Delhi, India. It was founded in 1922 by an Act of the Central Legislative Assembly.</p>
                
                <h3>Academic Structure</h3>
                <p>The university consists of 16 faculties and 86 departments distributed across its North and South campuses, offering 80 undergraduate and postgraduate courses.</p>
                
                <h3>Reputation</h3>
                <p>DU is known for its high standards in teaching and research and attracts students from all over India and abroad.</p>',
                'address' => 'University Road',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'country' => 'India',
                'pincode' => '110007',
                'phone' => '01127667011',
                'email' => 'vc@du.ac.in',
                'website' => 'https://www.du.ac.in',
                'latitude' => 28.6882,
                'longitude' => 77.2109,
                'established_year' => 1922,
                'accreditation' => 'Grade A by NAAC',
                'affiliation' => 'UGC',
                'type' => 'government',
                'campus_size' => '280 acres',
                'total_students' => 132435,
                'total_faculty' => 6560,
                'logo' => 'colleges/logo/du.png',
                'cover_image' => 'colleges/cover/du.jpg',
                'gallery_images' => [
                    'colleges/gallery/du1.jpg',
                    'colleges/gallery/du2.jpg'
                ],
                'nirf_ranking' => 11,
                'rating' => 4.5,
                'review_count' => 189,
                'fees_structure' => [
                    'BA' => 15000,
                    'BCom' => 18000,
                    'BSc' => 20000,
                    'MA' => 12000,
                    'MCom' => 15000,
                    'MSc' => 18000
                ],
                'admission_process' => 'Admission through CUET (Common University Entrance Test) for undergraduate programs and entrance tests for postgraduate programs.',
                'eligibility_criteria' => [
                    ['criteria' => 'CUET Score', 'description' => 'For undergraduate programs'],
                    ['criteria' => 'Minimum 60%', 'description' => 'in 12th standard'],
                    ['criteria' => 'Entrance Test', 'description' => 'For postgraduate programs']
                ],
                'application_deadline' => '2024-06-30',
                'academic_year_start' => '2024-07-20',
                'facilities' => ['Central Library', 'Hostels', 'Sports Grounds', 'Auditorium', 'Computer Centers', 'Medical Facilities'],
                'average_package' => 650000,
                'highest_package' => 2500000,
                'top_recruiters' => ['Deloitte', 'KPMG', 'EY', 'HDFC Bank', 'ICICI Bank'],
                'placement_percentage' => 70,
                'meta_title' => 'University of Delhi - Top Central University in India',
                'meta_description' => 'Delhi University offers BA, BCom, BSc, MA, MCom, MSc programs with excellent faculty and infrastructure.',
                'meta_keywords' => 'delhi university, du, arts college, science college, ugc university',
                'is_featured' => true,
                'status' => 'published',
                'views_count' => 9800
            ],

            [
                'name' => 'All India Institute of Medical Sciences',
                'slug' => 'aiims-medical-college-delhi',
                'short_description' => 'Premier medical college and hospital for medical education and research',
                'description' => '<h2>About AIIMS Delhi</h2>
                <p>All India Institute of Medical Sciences, New Delhi is a medical college and medical research public university based in New Delhi, India.</p>
                
                <h3>Excellence in Medical Education</h3>
                <p>AIIMS is consistently ranked as the top medical college in India and offers undergraduate, postgraduate, and doctoral programs in medicine.</p>
                
                <h3>Research and Healthcare</h3>
                <p>The institute operates as a public hospital and provides healthcare services while conducting medical research.</p>',
                'address' => 'Ansari Nagar',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'country' => 'India',
                'pincode' => '110029',
                'phone' => '01126588500',
                'email' => 'info@aiims.edu',
                'website' => 'https://www.aiims.edu',
                'latitude' => 28.5675,
                'longitude' => 77.2101,
                'established_year' => 1956,
                'accreditation' => 'Autonomous Institution',
                'affiliation' => 'Ministry of Health',
                'type' => 'government',
                'campus_size' => '175 acres',
                'total_students' => 4200,
                'total_faculty' => 780,
                'logo' => 'colleges/logo/aiims.png',
                'cover_image' => 'colleges/cover/aiims.jpg',
                'gallery_images' => [
                    'colleges/gallery/aiims1.jpg',
                    'colleges/gallery/aiims2.jpg',
                    'colleges/gallery/aiims3.jpg',
                    'colleges/gallery/aiims4.jpg'
                ],
                'nirf_ranking' => 1,
                'rating' => 4.9,
                'review_count' => 312,
                'fees_structure' => [
                    'MBBS' => 5800,
                    'MD/MS' => 12000,
                    'DM/MCh' => 25000
                ],
                'admission_process' => 'Admission through NEET-UG for MBBS and NEET-PG for postgraduate medical courses.',
                'eligibility_criteria' => [
                    ['criteria' => 'NEET-UG Rank', 'description' => 'For MBBS program'],
                    ['criteria' => 'Minimum 60%', 'description' => 'in PCB subjects'],
                    ['criteria' => 'Age Limit', 'description' => '17-25 years for MBBS']
                ],
                'application_deadline' => '2024-03-31',
                'academic_year_start' => '2024-08-01',
                'facilities' => ['Super Specialty Hospital', 'Research Labs', 'Medical Library', 'Hostels', 'Sports Complex'],
                'average_package' => 1200000,
                'highest_package' => 3500000,
                'top_recruiters' => ['Government Hospitals', 'Private Hospitals', 'Research Institutes', 'Pharmaceutical Companies'],
                'placement_percentage' => 95,
                'meta_title' => 'AIIMS Delhi - Best Medical College in India',
                'meta_description' => 'All India Institute of Medical Sciences Delhi offers MBBS, MD, MS, DM, MCh programs with world-class medical education.',
                'meta_keywords' => 'aiims, medical college, mbbs, medical education, neet',
                'is_featured' => true,
                'status' => 'published',
                'views_count' => 15600
            ],

            [
                'name' => 'National Institute of Fashion Technology',
                'slug' => 'nift-fashion-design-college',
                'short_description' => 'Premier fashion institute offering design, technology, and management programs',
                'description' => '<h2>About NIFT Delhi</h2>
                <p>National Institute of Fashion Technology is a fashion institute in India. It was set up in 1986 under the aegis of the Ministry of Textiles, Government of India.</p>
                
                <h3>Design Education</h3>
                <p>NIFT offers undergraduate, postgraduate and doctoral programs in design, management and technology for the fashion industry.</p>
                
                <h3>Industry Connect</h3>
                <p>The institute has strong industry connections and provides excellent placement opportunities in fashion and lifestyle sectors.</p>',
                'address' => 'Hauz Khas',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'country' => 'India',
                'pincode' => '110016',
                'phone' => '01126542100',
                'email' => 'contact@nift.ac.in',
                'website' => 'https://www.nift.ac.in',
                'latitude' => 28.5478,
                'longitude' => 77.1902,
                'established_year' => 1986,
                'accreditation' => 'Grade A by NAAC',
                'affiliation' => 'Autonomous',
                'type' => 'government',
                'campus_size' => '15 acres',
                'total_students' => 1200,
                'total_faculty' => 85,
                'logo' => 'colleges/logo/nift.png',
                'cover_image' => 'colleges/cover/nift.jpg',
                'gallery_images' => [
                    'colleges/gallery/nift1.jpg',
                    'colleges/gallery/nift2.jpg'
                ],
                'nirf_ranking' => 1,
                'rating' => 4.6,
                'review_count' => 167,
                'fees_structure' => [
                    'BDes' => 450000,
                    'MDes' => 350000,
                    'MFM' => 300000
                ],
                'admission_process' => 'Admission through NIFT Entrance Exam comprising Creative Ability Test (CAT), General Ability Test (GAT), and Situation Test.',
                'eligibility_criteria' => [
                    ['criteria' => 'NIFT Entrance', 'description' => 'Entrance exam score'],
                    ['criteria' => 'Minimum 50%', 'description' => 'in 12th standard'],
                    ['criteria' => 'Portfolio', 'description' => 'For some design courses']
                ],
                'application_deadline' => '2024-01-31',
                'academic_year_start' => '2024-07-15',
                'facilities' => ['Design Studios', 'Computer Labs', 'Library', 'Auditorium', 'Hostels', 'Exhibition Space'],
                'average_package' => 800000,
                'highest_package' => 2000000,
                'top_recruiters' => ['Armani', 'FabIndia', 'Future Group', 'Myntra', 'Reliance Trends'],
                'placement_percentage' => 82,
                'meta_title' => 'NIFT Delhi - Top Fashion Design Institute in India',
                'meta_description' => 'National Institute of Fashion Technology Delhi offers fashion design, technology and management programs with excellent placement.',
                'meta_keywords' => 'nift, fashion design, fashion institute, design college',
                'is_featured' => false,
                'status' => 'published',
                'views_count' => 7800
            ],

            [
                'name' => 'Indian Institute of Management Ahmedabad',
                'slug' => 'iim-ahmedabad-mba-college',
                'short_description' => 'Premier business school offering MBA and executive education programs',
                'description' => '<h2>About IIM Ahmedabad</h2>
                <p>Indian Institute of Management Ahmedabad is a business school located in Ahmedabad, Gujarat, India. The institute has been consistently ranked as the top business school in India.</p>
                
                <h3>Management Education</h3>
                <p>IIMA offers postgraduate, doctoral, and executive education programs in management. The PGP (MBA) program is its flagship offering.</p>
                
                <h3>Global Recognition</h3>
                <p>The institute is globally recognized and its alumni hold leadership positions in corporations worldwide.</p>',
                'address' => 'Vastrapur',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'country' => 'India',
                'pincode' => '380015',
                'phone' => '07966323456',
                'email' => 'admission@iima.ac.in',
                'website' => 'https://www.iima.ac.in',
                'latitude' => 23.0330,
                'longitude' => 72.5336,
                'established_year' => 1961,
                'accreditation' => 'Triple Crown Accreditation',
                'affiliation' => 'Autonomous',
                'type' => 'autonomous',
                'campus_size' => '106 acres',
                'total_students' => 1100,
                'total_faculty' => 110,
                'logo' => 'colleges/logo/iima.png',
                'cover_image' => 'colleges/cover/iima.jpg',
                'gallery_images' => [
                    'colleges/gallery/iima1.jpg',
                    'colleges/gallery/iima2.jpg',
                    'colleges/gallery/iima3.jpg'
                ],
                'nirf_ranking' => 1,
                'rating' => 4.9,
                'review_count' => 298,
                'fees_structure' => [
                    'PGP (MBA)' => 2300000,
                    'FPM (PhD)' => 0,
                    'Executive MBA' => 3500000
                ],
                'admission_process' => 'Admission through CAT (Common Admission Test) followed by Written Ability Test (WAT) and Personal Interview (PI).',
                'eligibility_criteria' => [
                    ['criteria' => 'CAT Score', 'description' => 'Minimum 99 percentile'],
                    ['criteria' => 'Bachelor Degree', 'description' => 'Minimum 50% marks'],
                    ['criteria' => 'Work Experience', 'description' => 'Preferred but not mandatory']
                ],
                'application_deadline' => '2024-09-30',
                'academic_year_start' => '2024-06-15',
                'facilities' => ['Library', 'Hostels', 'Sports Complex', 'Management Development Centre', 'Auditorium'],
                'average_package' => 3200000,
                'highest_package' => 5800000,
                'top_recruiters' => ['McKinsey', 'BCG', 'Bain', 'Goldman Sachs', 'Microsoft', 'Amazon'],
                'placement_percentage' => 100,
                'meta_title' => 'IIM Ahmedabad - Top MBA College in India',
                'meta_description' => 'Indian Institute of Management Ahmedabad offers MBA, PhD and executive programs with highest placement packages.',
                'meta_keywords' => 'iim ahmedabad, mba college, business school, cat, management education',
                'is_featured' => true,
                'status' => 'published',
                'views_count' => 14200
            ],

            [
                'name' => 'SRM Institute of Science and Technology',
                'slug' => 'srm-engineering-private-college',
                'short_description' => 'Leading private university offering engineering, medical and management programs',
                'description' => '<h2>About SRM University</h2>
                <p>SRM Institute of Science and Technology is a private higher education institute deemed to be university, located in Kattankulathur, Tamil Nadu, India.</p>
                
                <h3>Multi-disciplinary Education</h3>
                <p>SRM offers undergraduate, postgraduate and doctoral programs in Engineering, Management, Medicine, Science and Humanities.</p>
                
                <h3>Infrastructure</h3>
                <p>The university has state-of-the-art infrastructure including smart classrooms, research labs, and innovation centres.</p>',
                'address' => 'SRM Nagar, Kattankulathur',
                'city' => 'Chengalpattu',
                'state' => 'Tamil Nadu',
                'country' => 'India',
                'pincode' => '603203',
                'phone' => '04427452222',
                'email' => 'info@srmist.edu.in',
                'website' => 'https://www.srmist.edu.in',
                'latitude' => 12.8232,
                'longitude' => 80.0418,
                'established_year' => 1985,
                'accreditation' => 'Grade A++ by NAAC',
                'affiliation' => 'Deemed University',
                'type' => 'deemed',
                'campus_size' => '250 acres',
                'total_students' => 55000,
                'total_faculty' => 3200,
                'logo' => 'colleges/logo/srm.png',
                'cover_image' => 'colleges/cover/srm.jpg',
                'gallery_images' => [
                    'colleges/gallery/srm1.jpg',
                    'colleges/gallery/srm2.jpg'
                ],
                'nirf_ranking' => 35,
                'rating' => 4.3,
                'review_count' => 234,
                'fees_structure' => [
                    'BTech' => 450000,
                    'MBBS' => 2500000,
                    'MBA' => 600000,
                    'BSc' => 120000
                ],
                'admission_process' => 'Admission through SRMJEEE for engineering, NEET for medical, and SRMJEEM for management programs.',
                'eligibility_criteria' => [
                    ['criteria' => 'SRMJEEE Score', 'description' => 'For engineering programs'],
                    ['criteria' => 'NEET Score', 'description' => 'For medical programs'],
                    ['criteria' => 'Minimum 60%', 'description' => 'in qualifying exam']
                ],
                'application_deadline' => '2024-05-15',
                'academic_year_start' => '2024-07-01',
                'facilities' => ['Digital Library', 'Hostels', 'Sports Stadium', 'Medical Center', 'Food Courts', 'Transport'],
                'average_package' => 650000,
                'highest_package' => 1800000,
                'top_recruiters' => ['TCS', 'Infosys', 'Wipro', 'Cognizant', 'Amazon', 'Microsoft'],
                'placement_percentage' => 78,
                'meta_title' => 'SRM University - Top Private Engineering College in India',
                'meta_description' => 'SRM Institute of Science and Technology offers engineering, medical, management programs with good placement records.',
                'meta_keywords' => 'srm university, engineering college, private university, srmjee',
                'is_featured' => false,
                'status' => 'published',
                'views_count' => 8900
            ],

            [
                'name' => 'Christ University',
                'slug' => 'christ-university-arts-commerce',
                'short_description' => 'Premier private university offering arts, commerce, science and management programs',
                'description' => '<h2>About Christ University</h2>
                <p>Christ University is a private deemed-to-be-university located in Bangalore, Karnataka, India. Founded in 1969, it was granted the status of deemed university in 2008.</p>
                
                <h3>Liberal Arts Focus</h3>
                <p>The university emphasizes a liberal arts education and offers programs in humanities, social sciences, commerce, management, and sciences.</p>
                
                <h3>International Exposure</h3>
                <p>Christ has collaborations with universities worldwide and offers student exchange programs and international internships.</p>',
                'address' => 'Hosur Road',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'country' => 'India',
                'pincode' => '560029',
                'phone' => '08040129100',
                'email' => 'mail@christuniversity.in',
                'website' => 'https://christuniversity.in',
                'latitude' => 12.9345,
                'longitude' => 77.6061,
                'established_year' => 1969,
                'accreditation' => 'Grade A by NAAC',
                'affiliation' => 'Deemed University',
                'type' => 'deemed',
                'campus_size' => '75 acres',
                'total_students' => 21000,
                'total_faculty' => 1100,
                'logo' => 'colleges/logo/christ.png',
                'cover_image' => 'colleges/cover/christ.jpg',
                'gallery_images' => [
                    'colleges/gallery/christ1.jpg',
                    'colleges/gallery/christ2.jpg',
                    'colleges/gallery/christ3.jpg'
                ],
                'nirf_ranking' => 45,
                'rating' => 4.4,
                'review_count' => 198,
                'fees_structure' => [
                    'BA' => 180000,
                    'BCom' => 160000,
                    'BBA' => 220000,
                    'MA' => 120000,
                    'MBA' => 400000
                ],
                'admission_process' => 'Admission through Christ University Entrance Test (CUET) followed by Skill Assessment, Micro Presentation, and Personal Interview.',
                'eligibility_criteria' => [
                    ['criteria' => 'CUET Score', 'description' => 'University entrance test'],
                    ['criteria' => 'Minimum 60%', 'description' => 'in 12th standard'],
                    ['criteria' => 'English Proficiency', 'description' => 'Good communication skills']
                ],
                'application_deadline' => '2024-03-31',
                'academic_year_start' => '2024-06-15',
                'facilities' => ['Central Library', 'Hostels', 'Sports Complex', 'Auditoriums', 'Cafeteria', 'Medical Center'],
                'average_package' => 550000,
                'highest_package' => 1500000,
                'top_recruiters' => ['Deloitte', 'KPMG', 'EY', 'ICICI Bank', 'HDFC Bank', 'Amazon'],
                'placement_percentage' => 75,
                'meta_title' => 'Christ University Bangalore - Top Arts & Commerce College',
                'meta_description' => 'Christ University offers BA, BCom, BBA, MA, MBA programs with excellent infrastructure and placement opportunities.',
                'meta_keywords' => 'christ university, arts college, commerce college, bangalore university',
                'is_featured' => false,
                'status' => 'published',
                'views_count' => 7600
            ]
        ];

        foreach ($colleges as $collegeData) {
            // Remove courses from college data if present
            $coursesToAttach = [];
            if (isset($collegeData['courses'])) {
                $coursesToAttach = $collegeData['courses'];
                unset($collegeData['courses']);
            }

            // Create college
            $college = College::create($collegeData);

            // Attach random courses to college
            if (!empty($courseIds)) {
                $randomCourseIds = array_rand($courseIds, min(4, count($courseIds)));
                if (!is_array($randomCourseIds)) {
                    $randomCourseIds = [$randomCourseIds];
                }
                
                $coursesData = [];
                foreach ($randomCourseIds as $courseId) {
                    $coursesData[$courseIds[$courseId]] = [
                        'fees' => rand(50000, 300000),
                        'duration' => rand(3, 5) . ' Years',
                        'intake' => ['yearly', 'january', 'july'][rand(0, 2)],
                        'seats' => rand(30, 120)
                    ];
                }
                
                $college->courses()->sync($coursesData);
            }
        }

        $this->command->info('Colleges created successfully!');
        $this->command->info('Total Colleges: ' . count($colleges));
        
        // Display created colleges
        foreach ($colleges as $college) {
            $this->command->info('✓ ' . $college['name']);
        }
    }
}