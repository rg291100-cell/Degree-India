<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        
        
        // Sample blog data with SEO fields
        $blogs = [
            [
                'title' => 'How to Choose the Right College for Your Career',
                'excerpt' => 'A comprehensive guide to selecting the perfect college based on your career aspirations and personal preferences.',
                'content' => '<p>Choosing the right college is one of the most important decisions in a student\'s life. It affects your career, personal growth, and future opportunities. In this article, we\'ll explore key factors to consider when selecting a college.</p><h2>1. Academic Programs</h2><p>Research the courses offered and their curriculum structure.</p><h2>2. Campus Facilities</h2><p>Check infrastructure, library, labs, and other facilities.</p><h2>3. Placement Records</h2><p>Analyze past placement statistics and companies visiting.</p>',
                'status' => 'published',
                'seo_fields' => [
                    'meta_title' => 'How to Choose College - Career Guide',
                    'meta_description' => 'Learn how to select the right college for your career goals with our comprehensive guide.',
                    'meta_keywords' => ['college selection', 'career guidance', 'education', 'university']
                ]
            ],
            [
                'title' => 'Top 10 Engineering Colleges in India 2024',
                'excerpt' => 'Ranking and detailed analysis of the best engineering colleges in India for the academic year 2024.',
                'content' => '<p>Engineering remains one of the most sought-after career paths in India. Here are the top 10 engineering colleges:</p><ol><li>IIT Bombay</li><li>IIT Delhi</li><li>IIT Madras</li><li>IIT Kanpur</li><li>IIT Kharagpur</li><li>BITS Pilani</li><li>NIT Trichy</li><li>IIT Roorkee</li><li>DTU Delhi</li><li>VIT Vellore</li></ol><p>Each institute has its unique strengths and specializations.</p>',
                'status' => 'published',
                'seo_fields' => [
                    'meta_title' => 'Top 10 Engineering Colleges India 2024 Rankings',
                    'meta_description' => 'Complete ranking of best engineering colleges in India with placement and admission details.',
                    'meta_keywords' => ['engineering colleges', 'IIT', 'NIT', 'top colleges', 'rankings 2024']
                ]
            ],
            [
                'title' => 'Scholarship Opportunities for Indian Students',
                'excerpt' => 'Complete guide to available scholarships, eligibility criteria, and application process for Indian students.',
                'content' => '<p>Education can be expensive, but numerous scholarships are available for deserving students. Here are some popular options:</p><h2>Government Scholarships</h2><ul><li>National Scholarship Portal</li><li>Post-Matric Scholarship</li><li>Merit-Cum-Means Scholarship</li></ul><h2>Private Scholarships</h2><ul><li>Narotam Sekhsaria Scholarship</li><li>HDFC Educational Crisis Scholarship</li><li>LIC Golden Jubilee Scholarship</li></ul><p>Application deadlines vary, so plan ahead.</p>',
                'status' => 'published',
                'seo_fields' => [
                    'meta_title' => 'Scholarships for Indian Students 2024',
                    'meta_description' => 'Discover all available scholarships for Indian students with application guidelines and deadlines.',
                    'meta_keywords' => ['scholarships', 'financial aid', 'education funding', 'grants']
                ]
            ],
            [
                'title' => 'MBA vs PGDM: Which is Better for Your Career?',
                'excerpt' => 'Detailed comparison between MBA and PGDM programs to help you make the right choice for your management career.',
                'content' => '<p>Both MBA and PGDM are popular management courses, but they have distinct differences:</p><table border="1"><tr><th>Factor</th><th>MBA</th><th>PGDM</th></tr><tr><td>Approval</td><td>UGC/AICTE</td><td>AICTE</td></tr><tr><td>Curriculum</td><td>More theoretical</td><td>Industry-oriented</td></tr><tr><td>Flexibility</td><td>Limited</td><td>More flexible</td></tr></table><p>Choose based on your career goals and learning style.</p>',
                'status' => 'draft',
                'seo_fields' => [
                    'meta_title' => 'MBA vs PGDM Comparison Guide',
                    'meta_description' => 'Detailed comparison between MBA and PGDM programs to choose the right management course.',
                    'meta_keywords' => ['MBA', 'PGDM', 'management courses', 'career comparison']
                ]
            ],
            [
                'title' => 'Study Abroad: Complete Guide for Indian Students',
                'excerpt' => 'Step-by-step guide for Indian students planning to study abroad including visa, expenses, and admission process.',
                'content' => '<p>Studying abroad can be life-changing. Here\'s your complete guide:</p><h2>Step 1: Country Selection</h2><p>Consider USA, UK, Canada, Australia, Germany based on your budget and preferences.</p><h2>Step 2: University Shortlisting</h2><p>Research universities, rankings, and programs.</p><h2>Step 3: Entrance Exams</h2><p>Prepare for IELTS, TOEFL, GRE, GMAT as required.</p><h2>Step 4: Application Process</h2><p>Complete applications with all documents.</p><h2>Step 5: Visa Application</h2><p>Apply for student visa with financial proofs.</p>',
                'status' => 'published',
                'seo_fields' => [
                    'meta_title' => 'Study Abroad Guide for Indian Students',
                    'meta_description' => 'Complete step-by-step guide for Indian students planning to study abroad with all requirements.',
                    'meta_keywords' => ['study abroad', 'foreign education', 'overseas study', 'international students']
                ]
            ]
        ];

        // Create 5 blog entries
        foreach ($blogs as $key => $blogData) {
           
            
            // Generate slug from title
            $slug = Str::slug($blogData['title']);
            
            // Create blog with all fields
            Blog::create([
                'title' => $blogData['title'],
                'slug' => $slug . '-' . ($key + 1), // Add unique identifier
                'excerpt' => $blogData['excerpt'],
                'content' => $blogData['content'],
                'featured_image' => null, // You can add images if available
                'status' => $blogData['status'],
                'user_id' => '',
                'category_id' => '',
                'seo_fields' => $blogData['seo_fields'],
                'created_at' => now()->subDays($key * 2) // Stagger creation dates
            ]);
        }

        $this->command->info('✅ 5 blog entries created successfully!');
    }
}