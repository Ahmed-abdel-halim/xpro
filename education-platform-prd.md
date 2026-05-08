📘 Educational Platform – Product Requirements Document (PRD)
1. Project Overview

A modern, responsive educational platform built using Laravel that serves multiple educational stages:

Primary

Middle

Secondary

University

Labor Market (Professional Courses)

The platform connects students with teachers through structured educational content (video-based learning), with paid access and integrated local payment gateways.

2. System Architecture
2.1 Technology Stack

Backend: Laravel (Latest LTS)

Database: MySQL

Authentication: Laravel Breeze / Laravel Jetstream

API: RESTful

Frontend: Blade or Inertia + Vue (optional)

Payments: Mobile Wallet APIs (Vodafone Cash, InstaPay, etc.)

Hosting: Linux-based server

3. User Roles
3.1 Admin

Full dashboard access

Manage stages, grades, subjects

Manage teachers & students

Set commission percentage

Approve teacher accounts

View reports & revenue

Control free trial settings

3.2 Teacher

Dashboard access

Choose:

Stage

Grade

Subject

Term/Duration

Upload videos

View earnings

View enrolled students

See commission deductions

First month free (no commission)

3.3 Student

Browse stages → grades → subjects → teachers

View teacher profiles

Choose teacher

Pay for subject access

Watch purchased videos

Responsive access (mobile/tablet/desktop)

4. Platform Structure (Educational Hierarchy)
Stage
 └── Grade
      └── Subject
           └── Teachers (2 per subject minimum)
                └── Videos
Example

Primary
→ Grade 1
→ Math
→ Teacher A
→ Teacher B
→ Videos for each teacher

5. Core Features
5.1 Stage Management

Admin can:

Create stages

Edit stages

Delete stages

Fields:

Name

Description

Image

5.2 Grade Management

Each stage contains multiple grades.

Fields:

Stage ID (foreign key)

Name (KG1, Grade 1, etc.)

Description

5.3 Subject Management

Each grade contains subjects.

Fields:

Grade ID (foreign key)

Name

Description

5.4 Teacher Content Upload

Teacher selects:

Stage

Grade

Subject

Term/Duration

Then uploads:

Video Title

Video Description

Video File / Streaming URL

Thumbnail

Price

5.5 Student Flow

Register/Login

Choose Stage

Choose Grade

Choose Subject

View Teachers (2 minimum)

Select Teacher

Pay

Unlock videos

6. Payment System

Supported Payment Methods:

Vodafone Cash

InstaPay

Mobile Wallet APIs

Manual verification option (if needed)

Payment Logic

Student pays for subject access

Platform takes commission %

Teacher receives remaining amount

Example:

Subject price: 100 EGP

Commission: 20%

Teacher receives: 80 EGP

7. Commission System

Admin controls:

Commission percentage

First month free for teacher (0% commission)

Ability to disable commission for specific teacher

Logic:

If teacher.created_at < 30 days → 0% commission

Else → Apply commission %

8. Dashboard Requirements
Admin Dashboard

Total Users

Total Teachers

Total Students

Total Revenue

Commission Revenue

Active Subscriptions

Pending Payments

Teacher Dashboard

Uploaded Courses

Total Students

Earnings

Commission deducted

Free month remaining days

9. Responsive Design Requirements

Fully mobile-friendly

Tablet compatible

Desktop optimized

Modern UI

Clean typography

Professional educational theme

Use:

Bootstrap 5 or Tailwind CSS

10. Database Structure (High-Level)
Tables

users

roles

stages

grades

subjects

teachers

videos

payments

enrollments

commissions

Example Relationships

Stage hasMany Grades

Grade hasMany Subjects

Subject hasMany Teachers

Teacher hasMany Videos

Student belongsToMany Subjects

Payment belongsTo Student

Payment belongsTo Teacher

11. Security Requirements

Role-based access control

Video protection (no direct URL access)

Auth middleware

CSRF protection

Secure payment verification

12. Video Protection

Store videos in private storage

Serve via signed URLs

Prevent download (if possible)

Optional: Use streaming service (Vimeo private / AWS S3 signed URL)

13. Free Trial Logic

Teacher:

First 30 days → no commission

Student:

Optional: preview lesson (first video free)

14. Future Enhancements (Phase 2)

Live classes (Zoom integration)

Ratings & Reviews

Certificates

AI recommendations

Notifications

Mobile app (Flutter)

15. Non-Functional Requirements

Scalable

Secure

Fast loading

SEO optimized

Clean code architecture (MVC)

REST API ready

16. Project Goals

Centralized educational system

Multi-stage learning structure

Revenue sharing model

Simple teacher onboarding

Modern professional design