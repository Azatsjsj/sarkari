@extends('layouts.app')


@section('title', 'Terms of Service - SarkariResult.Mobi')

@section('description', 'Read our comprehensive These Terms of Service (“Terms”) constitute a legally binding agreement.')


@section('content')
<style>
        .tos-container {
            max-width: 1280px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 25px 45px -12px rgba(0,0,0,0.1);
        }
        /* Header */
        .site-header {
            background: linear-gradient(105deg, #0a2e4d 0%, #123e60 100%);
            color: white;
            padding: 1.3rem 2rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #f7b32b;
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .logo-mark {
            background: #f7b32b;
            width: 48px;
            height: 48px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.6rem;
            color: #0a2e4d;
        }
        .brand-text h1 {
            font-size: 1.6rem;
            letter-spacing: -0.3px;
        }
        .brand-text span {
            font-size: 0.75rem;
            opacity: 0.85;
        }
        .nav-links {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 30px;
            transition: 0.2s;
        }
        .nav-links a:hover {
            background: rgba(255,255,255,0.18);
        }
        /* Main content */
        .tos-content {
            padding: 2rem 2rem 3rem;
        }
        .page-title {
            border-left: 6px solid #f7b32b;
            padding-left: 22px;
            margin-bottom: 2rem;
        }
        .page-title h2 {
            font-size: 2.4rem;
            font-weight: 700;
            color: #0c3b5e;
        }
        .update-date {
            color: #4a627a;
            margin-top: 8px;
            font-size: 0.9rem;
        }
        /* Table of Contents */
        .toc-card {
            background: #f8fafc;
            border-radius: 24px;
            padding: 1rem 1.8rem;
            margin-bottom: 2rem;
            border: 1px solid #e2edf7;
            display: flex;
            flex-wrap: wrap;
            gap: 0.7rem;
            align-items: center;
        }
        .toc-label {
            font-weight: 700;
            color: #0f3b5c;
            background: #e6f0fa;
            padding: 5px 12px;
            border-radius: 40px;
            font-size: 0.8rem;
        }
        .toc-card a {
            background: white;
            padding: 5px 14px;
            border-radius: 40px;
            text-decoration: none;
            color: #1f6392;
            font-size: 0.85rem;
            border: 1px solid #cfdfed;
            transition: 0.1s;
        }
        .toc-card a:hover {
            background: #eef3fc;
            border-color: #94a3b8;
        }
        /* Terms sections */
        .terms-section {
            background: #ffffff;
            border-radius: 28px;
            margin-bottom: 2rem;
            border: 1px solid #eef2f8;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .terms-section h3 {
            background: #fbfdfe;
            padding: 1rem 1.8rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #155a8a;
            border-bottom: 2px solid #e6edf4;
        }
        .section-body {
            padding: 1.4rem 1.8rem;
        }
        .section-body p {
            margin-bottom: 1rem;
        }
        .section-body ul, .section-body ol {
            margin: 0.8rem 0 0.8rem 1.6rem;
        }
        .section-body li {
            margin: 0.5rem 0;
        }
        .highlight-box {
            background: #fef7e0;
            border-left: 5px solid #f7b32b;
            padding: 1rem 1.5rem;
            border-radius: 18px;
            margin: 1.2rem 0;
        }
        .badge-legal {
            background: #e9f1f9;
            color: #175d8f;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 30px;
            display: inline-block;
            margin-right: 8px;
        }
        .contact-grievance {
            background: #eef4ff;
            border-radius: 24px;
            padding: 1.2rem;
            margin-top: 1rem;
            border: 1px solid #cbdff2;
        }
        footer {
            background: #0f172f;
            color: #cbd5e6;
            padding: 2rem;
            text-align: center;
            font-size: 0.85rem;
            border-top: 1px solid #253553;
        }
        footer a {
            color: #facc15;
            text-decoration: none;
        }
        hr {
            margin: 1rem 0;
        }
        @media (max-width: 750px) {
            .site-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            .tos-content {
                padding: 1.5rem;
            }
            .page-title h2 {
                font-size: 1.8rem;
            }
            .terms-section h3 {
                font-size: 1.3rem;
            }
            .section-body {
                padding: 1.2rem;
            }
        }
    </style>

<div class="tos-container">
    <!-- Header -->
    <header class="site-header">
        <div class="logo-area">
            <div class="logo-mark">YS</div>
            <div class="brand-text">
                <h1>sarkariresult.mobi</h1>
                <span>Reliable. Transparent. Secure.</span>
            </div>
        </div>
    </header>

    <!-- Main Terms Content -->
    <div class="tos-content">
        <div class="page-title">
            <h2>Terms of Service</h2>
            <div class="update-date"><strong>Effective Date:</strong> April 2, 2026 | <strong>Last Modified:</strong> April 2, 2026</div>
        </div>

        <!-- Quick Navigation -->
        <div class="toc-card">
            <span class="toc-label">Jump to</span>
            <a href="#acceptance">✅ Acceptance</a>
            <a href="#changes">🔄 Changes</a>
            <a href="#use">📋 Permitted Use</a>
            <a href="#prohibited">⛔ Prohibited Conduct</a>
            <a href="#intellectual">©️ IP Rights</a>
            <a href="#disclaimers">⚠️ Disclaimers</a>
            <a href="#liability">⚖️ Liability</a>
            <a href="#indemnity">🛡️ Indemnity</a>
            <a href="#governing">🌍 Governing Law</a>
            <a href="#grievance">📞 Grievance</a>
        </div>

        <!-- Section 1: Acceptance -->
        <div class="terms-section" id="acceptance">
            <h3>1. Acceptance of Terms</h3>
            <div class="section-body">
                <p>Welcome to sarkariresult.mobi (“Company”, “we”, “us”, “our”). These Terms of Service (“Terms”) constitute a legally binding agreement between you (“User”, “you”, “your”) and sarkariresult.mobi regarding your access to and use of the website <strong>https://sarkariresult.mobi</strong> and any associated applications, tools, or services (collectively, the “Platform”).</p>
                <p>By accessing, browsing, or using the Platform in any way (including viewing content, submitting forms, or interacting with features), you acknowledge that you have read, understood, and agree to be bound by these Terms. If you do not agree, you must immediately cease using the Platform.</p>
                <div class="highlight-box">
                    📌 <strong>Note:</strong> These Terms apply to all users, including visitors, registered users, and contributors. Additional terms may apply to specific services or promotions, which will be presented to you at the time of use.
                </div>
            </div>
        </div>

        <!-- Section 2: Modifications -->
        <div class="terms-section" id="changes">
            <h3>2. Modifications to Terms</h3>
            <div class="section-body">
                <p>We reserve the right to revise, update, or replace these Terms at any time at our sole discretion. Changes become effective immediately upon posting on this page. Material changes will be communicated via a prominent notice on the website or via email (if you have provided your contact details).</p>
                <p>Your continued use of the Platform after any modification constitutes your acceptance of the revised Terms. We encourage you to review this page periodically to stay informed.</p>
            </div>
        </div>

        <!-- Section 3: Permitted Use -->
        <div class="terms-section" id="use">
            <h3>3. Permitted Use & Eligibility</h3>
            <div class="section-body">
                <p>You must be at least 13 years of age to use our Platform. If you are between 13 and 18, you represent that you have parental or legal guardian consent to these Terms. You agree to use the Platform only for lawful purposes and in accordance with these Terms.</p>
                <p>We grant you a limited, non-exclusive, non-transferable, revocable license to access and use the Platform for personal, non-commercial purposes, unless explicitly authorized otherwise.</p>
                <ul>
                    <li>You may view, download, or print publicly available content for personal reference.</li>
                    <li>You must not misuse, exploit, or attempt to gain unauthorized access to any part of the Platform.</li>
                    <li>You are responsible for maintaining the confidentiality of any account credentials (if applicable) and for all activities under your account.</li>
                </ul>
            </div>
        </div>

        <!-- Section 4: Prohibited Conduct -->
        <div class="terms-section" id="prohibited">
            <h3>4. Prohibited Activities & Restrictions</h3>
            <div class="section-body">
                <p>You agree NOT to engage in any of the following prohibited activities:</p>
                <ul>
                    <li>Violating any applicable local, state, national, or international law or regulation.</li>
                    <li>Uploading, transmitting, or distributing any malicious code, viruses, worms, or harmful components.</li>
                    <li>Attempting to interfere with, disrupt, or overload the Platform’s infrastructure or servers.</li>
                    <li>Scraping, data mining, or using automated bots to extract content without our prior written consent.</li>
                    <li>Impersonating any person or entity, or falsely stating your affiliation with any organization.</li>
                    <li>Posting or transmitting any unlawful, defamatory, obscene, harassing, or otherwise objectionable content.</li>
                    <li>Reverse engineering, decompiling, or disassembling any software or underlying code of the Platform.</li>
                </ul>
                <p>We reserve the right to suspend or terminate your access immediately for any violation of this section, without prior notice.</p>
            </div>
        </div>

        <!-- Section 5: Intellectual Property -->
        <div class="terms-section" id="intellectual">
            <h3>5. Intellectual Property Rights</h3>
            <div class="section-body">
                <p>All content, features, and functionality available on the Platform – including but not limited to text, graphics, logos, icons, images, audio clips, digital downloads, data compilations, and software – are the exclusive property of sarkariresult.mobi or its licensors and are protected by Indian and international copyright, trademark, patent, and trade secret laws.</p>
                <p><span class="badge-legal">®</span> “sarkariresult.mobi” and the associated logo are registered trademarks. Unauthorized use of any trademark, service mark, or logo may result in legal action.</p>
                <p>You may not reproduce, distribute, modify, create derivative works of, publicly display, or commercially exploit any part of the Platform without our explicit written permission.</p>
                <div class="highlight-box">
                    💡 <strong>User Submissions:</strong> If you submit any feedback, comments, or suggestions, you grant us a perpetual, royalty-free, worldwide license to use, modify, and incorporate such feedback without any obligation to you.
                </div>
            </div>
        </div>

        <!-- Section 6: Disclaimers -->
        <div class="terms-section" id="disclaimers">
            <h3>6. Disclaimer of Warranties</h3>
            <div class="section-body">
                <p>THE PLATFORM AND ALL CONTENT, INFORMATION, AND SERVICES ARE PROVIDED ON AN “AS IS” AND “AS AVAILABLE” BASIS WITHOUT ANY WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED.</p>
                <p>WE DO NOT WARRANT THAT: (A) THE PLATFORM WILL FUNCTION UNINTERRUPTED, SECURE, OR AVAILABLE AT ANY PARTICULAR TIME; (B) ANY ERRORS OR DEFECTS WILL BE CORRECTED; (C) THE RESULTS OBTAINED FROM USING THE PLATFORM WILL BE ACCURATE OR RELIABLE.</p>
                <p>We make no representation regarding the completeness, accuracy, or timeliness of any information (e.g., job postings, exam dates, results) displayed. You are strongly advised to verify critical details from official or authoritative sources before making decisions.</p>
                <p>To the maximum extent permitted by law, we disclaim all warranties, including implied warranties of merchantability, fitness for a particular purpose, and non-infringement.</p>
            </div>
        </div>

        <!-- Section 7: Limitation of Liability -->
        <div class="terms-section" id="liability">
            <h3>7. Limitation of Liability</h3>
            <div class="section-body">
                <p>TO THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT SHALL sarkariresult.mobi, ITS DIRECTORS, EMPLOYEES, PARTNERS, OR AGENTS BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, INCLUDING WITHOUT LIMITATION, LOSS OF PROFITS, DATA, USE, GOODWILL, OR OTHER INTANGIBLE LOSSES, ARISING OUT OF OR IN CONNECTION WITH YOUR USE OR INABILITY TO USE THE PLATFORM.</p>
                <p>OUR TOTAL AGGREGATE LIABILITY FOR ANY CLAIMS ARISING FROM THESE TERMS OR YOUR USE OF THE PLATFORM SHALL NOT EXCEED THE GREATER OF (A) THE TOTAL AMOUNT YOU PAID TO US, IF ANY, DURING THE SIX (6) MONTHS PRIOR TO THE CLAIM, OR (B) ₹1000 (INR).</p>
                <p>Some jurisdictions do not allow the exclusion or limitation of certain damages, so these limitations may not apply to you to the extent prohibited by law.</p>
            </div>
        </div>

        <!-- Section 8: Indemnification -->
        <div class="terms-section" id="indemnity">
            <h3>8. Indemnification</h3>
            <div class="section-body">
                <p>You agree to indemnify, defend, and hold harmless sarkariresult.mobi and its affiliates, officers, employees, and agents from and against any and all claims, liabilities, damages, losses, costs, expenses, or fees (including reasonable attorneys’ fees) arising from:</p>
                <ul>
                    <li>Your violation of these Terms;</li>
                    <li>Your use or misuse of the Platform;</li>
                    <li>Your violation of any third-party rights, including intellectual property or privacy rights;</li>
                    <li>Any content you submit or transmit through the Platform.</li>
                </ul>
            </div>
        </div>

        <!-- Section 9: Governing Law & Dispute Resolution -->
        <div class="terms-section" id="governing">
            <h3>9. Governing Law & Jurisdiction</h3>
            <div class="section-body">
                <p>These Terms shall be governed by and construed in accordance with the laws of <strong>India</strong>, without regard to its conflict of law principles. Any legal suit, action, or proceeding arising out of or related to these Terms or the Platform shall be instituted exclusively in the courts located in <strong>New Delhi</strong>. You waive any objection to jurisdiction or venue in such courts.</p>
                <p>For users outside India, you agree that you are responsible for complying with local laws where applicable, and we make no representation that the Platform is appropriate or available for use in other locations.</p>
                <div class="highlight-box">
                    ⚖️ <strong>Dispute Resolution:</strong> Prior to initiating any formal legal proceedings, you agree to first contact us to attempt an informal resolution. If unresolved within 30 days, either party may pursue arbitration or legal action as per Indian law.
                </div>
            </div>
        </div>

        <!-- Section 10: Termination -->
        <div class="terms-section">
            <h3>10. Suspension & Termination</h3>
            <div class="section-body">
                <p>We may suspend or terminate your access to all or part of the Platform at any time, with or without cause, effective immediately, without prior notice. Grounds for termination include, but are not limited to, breach of these Terms or illegal conduct.</p>
                <p>Upon termination, your right to use the Platform ceases immediately. Provisions that by their nature should survive termination (including intellectual property, disclaimers, indemnity, limitation of liability) shall survive.</p>
            </div>
        </div>

        <!-- Section 11: Grievance & Contact -->
        <div class="terms-section" id="grievance">
            <h3>11. Grievance Redressal & Contact Information</h3>
            <div class="section-body">
                <p>If you have any complaints, questions, or concerns regarding these Terms or the Platform, please contact our designated Grievance Officer under the Information Technology (Intermediary Guidelines and Digital Media Ethics Code) Rules, 2021:</p>
                <div class="contact-grievance">
                    <p><strong>Grievance Officer:</strong> Mr. Arjun Mehta (Compliance Lead)<br>
                    <strong>Email:</strong> legal@sarkariresult.mobi |  <strong>Alternate:</strong> grievance@sarkariresult.mobi<br>
                    <strong>Postal Address:</strong> sarkariresult.mobi, 4th Floor, Cyber Heights, New Delhi - 110001, India<br>
                    <strong>Response Time:</strong> Acknowledgment within 24 hours (business days); resolution within 30 days.</p>
                </div>
                <p>For general inquiries about these Terms, you may also write to <strong>support@sarkariresult.mobi</strong>. We strive to address all legitimate concerns promptly and fairly.</p>
            </div>
        </div>

        <!-- Section 12: Entire Agreement -->
        <div class="terms-section">
            <h3>12. Entire Agreement & Severability</h3>
            <div class="section-body">
                <p>These Terms, together with our <a href="/privacy-policy">Privacy Policy</a> and any other legal notices published by us, constitute the entire agreement between you and sarkariresult.mobi regarding the Platform. If any provision of these Terms is held to be invalid or unenforceable by a court of competent jurisdiction, the remaining provisions shall remain in full force and effect.</p>
                <p>Our failure to enforce any right or provision of these Terms shall not be deemed a waiver of such right or provision.</p>
                <hr>
                <p style="font-size: 0.85rem; color: #4b5563;">By using sarkariresult.mobi, you acknowledge that you have read, understood, and agreed to be bound by these Terms of Service. Thank you for being a responsible user.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p style="margin-top: 8px;">Registered under Indian Trademark Act. For advertising or partnerships: advertise@sarkariresult.mobi</p>
        <p style="margin-top: 12px; font-size: 0.7rem;">Disclaimer: This platform is an independent information provider. We are not affiliated with any government entity unless explicitly mentioned. Always refer to official sources for authoritative information.</p>
    </footer>
</div>
@endsection