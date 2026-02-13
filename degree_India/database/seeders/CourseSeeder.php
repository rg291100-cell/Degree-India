<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // Clear existing courses if any
        Course::truncate();

        $courses = [
            [
                'user_id' => 2,
                'category_id' => 3,
                'title' => 'Full Stack Web Development Bootcamp',
                'slug' => 'full-stack-web-development-bootcamp',
                'short_description' => 'Master frontend and backend development with MERN stack',
                'description' => '<p>This comprehensive bootcamp covers everything from HTML/CSS to advanced React and Node.js development. You\'ll build real-world projects and learn industry best practices.</p>
                <p><strong>What you\'ll learn:</strong></p>
                <ul>
                    <li>HTML5, CSS3, JavaScript (ES6+)</li>
                    <li>React.js with Hooks and Context API</li>
                    <li>Node.js, Express.js, MongoDB</li>
                    <li>REST APIs and Authentication</li>
                    <li>Deployment and DevOps basics</li>
                </ul>',
                'course_type' => 'Diploma',
                'course_mode' => 'online',
                'duration' => 180,
                'duration_unit' => 'hours',
                'learning_format' => 'full-time',
                'total_sessions' => 60,
                'course_affiliation' => 'Tech University Certification',
                'key_features' => '<ul>
                    <li>Live project-based learning</li>
                    <li>Industry-recognized certification</li>
                    <li>Career support and job assistance</li>
                    <li>Lifetime access to course materials</li>
                    <li>Mentor support 24/7</li>
                </ul>',
                'skills_covered' => json_encode(['HTML5', 'CSS3', 'JavaScript', 'React', 'Node.js', 'MongoDB', 'Express.js', 'Git']),
                'course_advantage' => '<p>This course is designed by industry experts with 10+ years of experience. Our graduates are working at top tech companies.</p>',
                'syllabus' => '<div class="syllabus-module">
                    <h4>Module 1: Frontend Fundamentals</h4>
                    <p>HTML5, CSS3, JavaScript ES6+, Git Basics</p>
                </div>
                <div class="syllabus-module">
                    <h4>Module 2: React Development</h4>
                    <p>React Components, Hooks, Context API, Redux</p>
                </div>
                <div class="syllabus-module">
                    <h4>Module 3: Backend with Node.js</h4>
                    <p>Node.js, Express.js, REST APIs, Authentication</p>
                </div>
                <div class="syllabus-module">
                    <h4>Module 4: Database & Deployment</h4>
                    <p>MongoDB, Mongoose, Deployment, DevOps Basics</p>
                </div>',
                'fees' => 29999.00,
                'discounted_fees' => 19999.00,
                'admission_fee' => 1999.00,
                'discount_percentage' => 33,
                'currency' => 'INR',
                'education_qualification' => json_encode(['10+2 or equivalent', 'Basic computer knowledge']),
                'min_age' => 18,
                'max_age' => 45,
                'entrance_exam' => 'No entrance exam required',
                'course_outcomes' => json_encode([
                    'Build full-stack web applications',
                    'Understand frontend and backend architecture',
                    'Deploy applications to production',
                    'Work with databases and APIs',
                    'Follow coding best practices'
                ]),
                'eligibility_criteria' => json_encode([
                    'Basic understanding of computers',
                    'Internet connection for online classes',
                    'Dedication to complete assignments',
                    'English language proficiency'
                ]),
                'career_scope' => '<p>Web developers are in high demand with average salaries ranging from 4-15 LPA. You can work as:</p>
                <ul>
                    <li>Frontend Developer</li>
                    <li>Backend Developer</li>
                    <li>Full Stack Developer</li>
                    <li>Web Application Developer</li>
                    <li>Freelance Developer</li>
                </ul>',
                'industry_trend' => 'Web development jobs are expected to grow 13% from 2020 to 2030, much faster than average.',
                'employment_areas' => json_encode(['IT Companies', 'Startups', 'E-commerce', 'Digital Agencies', 'Freelancing']),
                'expected_market_size' => '$50 Billion by 2025',
                'salary_range' => '₹4 LPA - ₹15 LPA',
                'course_highlights' => json_encode([
                    ['text' => '500+ Hours of Content', 'icon' => 'fas fa-clock'],
                    ['text' => '20+ Real Projects', 'icon' => 'fas fa-laptop-code'],
                    ['text' => 'Job Assistance', 'icon' => 'fas fa-briefcase'],
                    ['text' => 'Certificate of Completion', 'icon' => 'fas fa-certificate'],
                    ['text' => 'Lifetime Access', 'icon' => 'fas fa-infinity'],
                    ['text' => '24/7 Mentor Support', 'icon' => 'fas fa-headset']
                ]),
                'academic_partners' => json_encode([
                    ['name' => 'Tech University', 'website' => 'https://techuniversity.edu', 'logo' => 'https://cdn-icons-png.flaticon.com/512/3067/3067256.png'],
                    ['name' => 'Digital Skills Institute', 'website' => 'https://digitalskills.org', 'logo' => 'https://cdn-icons-png.flaticon.com/512/3067/3067256.png'],
                    ['name' => 'Coding Academy', 'website' => 'https://codingacademy.com', 'logo' => 'https://cdn-icons-png.flaticon.com/512/3067/3067256.png']
                ]),
                'thumbnail_image' => null,
                'banner_image' => null,
                'gallery_images' => json_encode([]),
                'level' => 'beginner',
                'status' => 'published',
                'order' => 1,
                'featured' => true,
                'has_prospectus' => false,
                'prospectus_file' => null,
                'enrollment_count' => 245,
                'rating' => 4.5,
                'total_reviews' => 89,
                'likes_count' => 156,
                'meta_title' => 'Full Stack Web Development Course | Learn MERN Stack',
                'meta_description' => 'Master full stack web development with our comprehensive bootcamp. Learn React, Node.js, MongoDB and build real projects.',
                'meta_keywords' => 'web development, MERN stack, react, node.js, mongodb, full stack course',
            ],
            [
                'user_id' => 4,
                'category_id' => 7,
                'title' => 'Data Science & Machine Learning',
                'slug' => 'data-science-machine-learning',
                'short_description' => 'Master Data Science, Machine Learning and AI with Python',
                'description' => '<p>This intensive course covers data analysis, visualization, machine learning algorithms, and AI concepts. Work with real datasets and build predictive models.</p>',
                'course_type' => 'Post Graduate',
                'course_mode' => 'both',
                'duration' => 240,
                'duration_unit' => 'hours',
                'learning_format' => 'part-time',
                'total_sessions' => 80,
                'course_affiliation' => 'AI Research Institute',
                'key_features' => '<ul>
                    <li>Hands-on with real datasets</li>
                    <li>Industry projects</li>
                    <li>Python programming</li>
                    <li>ML model deployment</li>
                </ul>',
                'skills_covered' => json_encode(['Python', 'Pandas', 'NumPy', 'Scikit-learn', 'TensorFlow', 'Data Visualization', 'Statistics']),
                'fees' => 39999.00,
                'discounted_fees' => 29999.00,
                'admission_fee' => 2999.00,
                'discount_percentage' => 25,
                'currency' => 'INR',
                'education_qualification' => json_encode(['Bachelor\'s degree in any field', 'Basic mathematics knowledge']),
                'min_age' => 20,
                'course_outcomes' => json_encode([
                    'Data analysis and visualization',
                    'Machine learning model building',
                    'Statistical analysis',
                    'Real-world project implementation'
                ]),
                'career_scope' => '<p>Data Scientists are among the highest paid professionals in tech industry.</p>',
                'salary_range' => '₹6 LPA - ₹25 LPA',
                'expected_market_size' => '$100 Billion by 2026',
                'course_highlights' => json_encode([
                    ['text' => 'Real Datasets', 'icon' => 'fas fa-database'],
                    ['text' => 'ML Projects', 'icon' => 'fas fa-robot'],
                    ['text' => 'Python Mastery', 'icon' => 'fab fa-python'],
                    ['text' => 'Career Guidance', 'icon' => 'fas fa-chart-line']
                ]),
                'level' => 'intermediate',
                'status' => 'published',
                'order' => 2,
                'featured' => true,
                'enrollment_count' => 189,
                'rating' => 4.7,
                'total_reviews' => 67,
                'likes_count' => 124,
                'meta_title' => 'Data Science & ML Course | Python, AI, Machine Learning',
                'meta_description' => 'Master Data Science and Machine Learning with Python. Learn data analysis, visualization, and build ML models.',
                'meta_keywords' => 'data science, machine learning, python, ai, ml course',
            ],
            [
                'user_id' => 2,
                'category_id' => 5,
                'title' => 'Digital Marketing Mastery',
                'slug' => 'digital-marketing-mastery',
                'short_description' => 'Become a certified digital marketing expert',
                'description' => '<p>Learn SEO, SEM, Social Media Marketing, Content Marketing and Analytics.</p>',
                'course_type' => 'Certificate',
                'course_mode' => 'online',
                'duration' => 120,
                'duration_unit' => 'hours',
                'fees' => 14999.00,
                'currency' => 'INR',
                'level' => 'beginner',
                'status' => 'published',
                'order' => 3,
                'featured' => false,
                'enrollment_count' => 312,
                'rating' => 4.3,
                'total_reviews' => 102,
                'likes_count' => 189,
                'meta_title' => 'Digital Marketing Course | SEO, SEM, Social Media Marketing',
                'meta_description' => 'Become a digital marketing expert. Learn SEO, SEM, social media marketing, content marketing and analytics.',
                'meta_keywords' => 'digital marketing, seo, sem, social media marketing, online marketing',
            ],
        ];

        foreach ($courses as $courseData) {
            Course::create($courseData);
        }

        $this->command->info('3 sample courses created successfully!');
        $this->command->info('1. Full Stack Web Development Bootcamp');
        $this->command->info('2. Data Science & Machine Learning');
        $this->command->info('3. Digital Marketing Mastery');
    }
}