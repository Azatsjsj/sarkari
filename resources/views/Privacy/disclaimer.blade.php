@extends('layouts.app')

@section('title', 'Disclaimer - SarkariResult.Mobi')

@section('description', 'Read our comprehensive Disclaimer to understand data collection, cookies, GDPR rights, and security measures.')


@section('content')

@stack('styles')
    <style>
        .disclaimer-container {
            max-width: 1280px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.08);
        }
        /* Header */
        .site-header {
            background: linear-gradient(135deg, #0b2b3b 0%, #144d6b 100%);
            color: white;
            padding: 1.3rem 2rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #f4a261;
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logo-icon {
            background: #f4a261;
            width: 50px;
            height: 50px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.7rem;
            color: #0b2b3b;
        }
        .brand-title h1 {
            font-size: 1.65rem;
            letter-spacing: -0.3px;
        }
        .brand-title p {
            font-size: 0.75rem;
            opacity: 0.85;
        }
        .nav-links {
            display: flex;
            gap: 1.1rem;
            flex-wrap: wrap;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 40px;
            transition: 0.2s;
        }
        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }
        /* Main Content */
        .disclaimer-content {
            padding: 2rem 2rem 3rem;
        }
        .page-header {
            border-left: 6px solid #f4a261;
            padding-left: 22px;
            margin-bottom: 2rem;
        }
        .page-header h2 {
            font-size: 2.4rem;
            font-weight: 700;
            color: #1f5068;
        }
        .update-date {
            color: #5a6e7c;
            margin-top: 8px;
            font-size: 0.9rem;
        }
        /* Quick jump */
        .quick-nav {
            background: #f8fafd;
            border-radius: 22px;
            padding: 0.8rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.7rem;
            align-items: center;
            border: 1px solid #e2edf5;
        }
        .nav-badge {
            background: #e4edf5;
            padding: 5px 14px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.8rem;
            color: #1f5068;
        }
        .quick-nav a {
            background: white;
            padding: 5px 14px;
            border-radius: 40px;
            text-decoration: none;
            color: #2c6e9e;
            font-size: 0.85rem;
            border: 1px solid #cfdfec;
            transition: 0.1s;
        }
        .quick-nav a:hover {
            background: #eef3fc;
            border-color: #9bb7d0;
        }
        /* Disclaimer Cards */
        .disclaimer-card {
            background: #ffffff;
            border-radius: 28px;
            margin-bottom: 1.8rem;
            border: 1px solid #eaf0f6;
            box-shadow: 0 1px 4px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .disclaimer-card h3 {
            background: #fbfefd;
            padding: 1rem 1.8rem;
            font-size: 1.45rem;
            font-weight: 600;
            color: #1a5d7e;
            border-bottom: 2px solid #eef3f9;
        }
        .card-body {
            padding: 1.4rem 1.8rem;
        }
        .card-body p {
            margin-bottom: 1rem;
        }
        .card-body ul, .card-body ol {
            margin: 0.8rem 0 0.8rem 1.6rem;
        }
        .card-body li {
            margin: 0.5rem 0;
        }
        .alert-box {
            background: #fff7eb;
            border-left: 5px solid #f4a261;
            padding: 1rem 1.5rem;
            border-radius: 18px;
            margin: 1.2rem 0;
        }
        .badge-law {
            background: #e9f2fa;
            color: #1a5d7e;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 30px;
            display: inline-block;
            margin-right: 8px;
        }
        .highlight-warning {
            background: #fee9e6;
            border-left-color: #d9534f;
        }
        footer {
            background: #0e1c2a;
            color: #b9cfdf;
            padding: 2rem;
            text-align: center;
            font-size: 0.85rem;
            border-top: 1px solid #1f3e52;
        }
        footer a {
            color: #f4a261;
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
            .disclaimer-content {
                padding: 1.5rem;
            }
            .page-header h2 {
                font-size: 1.9rem;
            }
            .disclaimer-card h3 {
                font-size: 1.3rem;
            }
            .card-body {
                padding: 1.2rem;
            }
        }
    </style>
<div class="disclaimer-container">
    <!-- Header Section -->
    <header class="site-header">
        <div class="logo-area">
            <div class="logo-icon">YS</div>
            <div class="brand-title">
                <h1>SarkariResult.mobi</h1>
                <p>Trust | Accuracy | Transparency</p>
            </div>
        </div>
    </header>

    <!-- Main Disclaimer Content -->
    <div class="disclaimer-content">
        <div class="page-header">
            <h2>Disclaimer</h2>
            <div class="update-date"><strong>Last Updated:</strong> April 2, 2026 | <strong>Effective Date:</strong> April 2, 2026</div>
        </div>

        <!-- Quick Navigation -->
        <div class="quick-nav">
            <span class="nav-badge">📑 On this page</span>
            <a href="#general">General Information</a>
            <a href="#accuracy">Accuracy & Completeness</a>
            <a href="#external">External Links</a>
            <a href="#professional">Professional Advice</a>
            <a href="#liability">Limitation of Liability</a>
            <a href="#testimonials">Testimonials</a>
            <a href="#updates">Updates</a>
        </div>

        <!-- 1. General Disclaimer -->
        <div class="disclaimer-card" id="general">
            <h3>1. General Information Only</h3>
            <div class="card-body">
                <p>The information provided on <strong>https://sarkariresult.mobi</strong> (the "Website") is for general informational and educational purposes only. Sarkariresult.mobi (referred to as "Company", "we", "us", or "our") makes no representation or warranty of any kind, express or implied, regarding the accuracy, adequacy, validity, reliability, availability, or completeness of any information on the Website.</p>
                <p>Your use of the Website and reliance on any information is solely at your own risk. This Website is not intended to be a substitute for professional advice, legal counsel, financial guidance, or official government notifications.</p>
                <div class="alert-box">
                    ⚠️ <strong>Important Notice:</strong> While we strive to provide timely and accurate updates (including job notifications, exam results, admit cards, or general news), we strongly recommend that you independently verify any critical information from official sources before making decisions or taking action.
                </div>
            </div>
        </div>

        <!-- 2. No Warranties / Accuracy -->
        <div class="disclaimer-card" id="accuracy">
            <h3>2. Accuracy & Completeness Disclaimer</h3>
            <div class="card-body">
                <p>We do not warrant that the information on this Website is error-free, complete, reliable, or current. Information may contain typographical errors, inaccuracies, or omissions. We reserve the right to correct any errors or update information without prior notice.</p>
                <p>To the fullest extent permitted by law, we disclaim all warranties, express or implied, including but not limited to implied warranties of merchantability, fitness for a particular purpose, title, and non-infringement. No oral or written information or advice given by us shall create any warranty.</p>
                <ul>
                    <li><strong>Third-party content:</strong> Any opinions, advice, or statements made by third parties (including advertisers or commenters) are theirs alone and do not reflect our endorsement.</li>
                    <li><strong>Official sources:</strong> For government exams, results, or recruitment, always refer to the official commission/board website.</li>
                </ul>
            </div>
        </div>

        <!-- 3. External Links Disclaimer -->
        <div class="disclaimer-card" id="external">
            <h3>3. External Links & Third-Party Websites</h3>
            <div class="card-body">
                <p>Our Website may contain links to external websites or resources that are not owned, operated, or controlled by Sarkariresult.mobi. We have no control over the content, privacy policies, or practices of any third-party websites.</p>
                <p>We provide these links for your convenience and reference only. The inclusion of any link does not imply endorsement, approval, or recommendation of the linked site. You acknowledge and agree that we shall not be held responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such content, goods, or services available on or through any such third-party websites.</p>
                <div class="alert-box highlight-warning">
                    🔗 <strong>Proceed with caution:</strong> When you leave our website, we encourage you to read the terms and privacy policy of any third-party site you visit.
                </div>
            </div>
        </div>

        <!-- 4. Professional Advice Disclaimer -->
        <div class="disclaimer-card" id="professional">
            <h3>4. Not Professional Advice</h3>
            <div class="card-body">
                <p>The information available on this Website is not intended to constitute legal, financial, medical, career, or any other type of professional advice. You should not act or refrain from acting based on any information provided on this Website without first seeking appropriate professional counsel tailored to your specific situation.</p>
                <p>Sarkariresult.mobi, its employees, owners, and affiliates shall not be liable for any decisions made or actions taken based on the content displayed. For specific concerns (e.g., eligibility criteria, recruitment rules, tax implications), consult an authorized professional or the relevant government authority.</p>
            </div>
        </div>

        <!-- 5. Limitation of Liability -->
        <div class="disclaimer-card" id="liability">
            <h3>5. Limitation of Liability</h3>
            <div class="card-body">
                <p>TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT SHALL Sarkariresult.mobi, ITS DIRECTORS, OFFICERS, EMPLOYEES, AGENTS, OR AFFILIATES BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES (INCLUDING, WITHOUT LIMITATION, LOSS OF PROFITS, DATA, USE, GOODWILL, OR OTHER INTANGIBLE LOSSES) ARISING OUT OF OR IN CONNECTION WITH:</p>
                <ul>
                    <li>Your access to or use of (or inability to access or use) the Website;</li>
                    <li>Any conduct or content of any third party on the Website;</li>
                    <li>Any information, content, or materials obtained from the Website;</li>
                    <li>Unauthorized access, use, or alteration of your transmissions or content.</li>
                </ul>
                <p>This limitation applies regardless of whether the alleged liability is based on contract, tort, negligence, strict liability, or any other basis, even if we have been advised of the possibility of such damage. Some jurisdictions do not allow the exclusion of certain warranties or limitations of liability, so the above limitations may not apply to you to the extent prohibited by law.</p>
            </div>
        </div>

        <!-- 6. Testimonials & User Experiences -->
        <div class="disclaimer-card" id="testimonials">
            <h3>6. Testimonials & User Submissions</h3>
            <div class="card-body">
                <p>Any testimonials, success stories, or user experiences shared on the Website are individual results and do not reflect typical outcomes. They are not intended to guarantee that you will achieve similar results. Your specific circumstances may vary.</p>
                <p>If you submit any feedback, comments, or content to us, you grant us a non-exclusive, royalty-free, perpetual license to use, modify, and display such submissions for promotional or operational purposes, without compensation to you.</p>
            </div>
        </div>

        <!-- 7. Changes & Updates to Disclaimer -->
        <div class="disclaimer-card" id="updates">
            <h3>7. Updates & Modifications</h3>
            <div class="card-body">
                <p>We reserve the right to modify, amend, or update this Disclaimer at any time without prior notice. Any changes will be effective immediately upon posting on this page. Your continued use of the Website following the posting of changes constitutes your acceptance of the revised Disclaimer.</p>
                <p>We encourage you to review this page periodically to stay informed about how we limit liability and present information. The "Last Updated" date at the top of this page indicates when the latest modifications were made.</p>
                <hr>
                <p><strong>Contact Us:</strong> If you have any questions or concerns about this Disclaimer, please contact us:</p>
                <div style="background:#f2f6fc; border-radius: 18px; padding: 12px 16px; margin-top: 12px;">
                    📧 Email: legal@Sarkariresult.mobi.com<br>
                    📞 Phone: +91-XXXXXXXXXX (Mon-Fri, 10 AM – 5 PM IST)<br>
                    📍 Address: Sarkariresult.mobi Legal Dept., 5th Floor, Cyber Heights, New Delhi - 110001, India
                </div>
            </div>
        </div>

        <!-- Final Notice - DMCA / Intellectual property reference -->
        <div class="disclaimer-card">
            <h3>8. DMCA & Intellectual Property Notice</h3>
            <div class="card-body">
                <p>We respect the intellectual property rights of others and expect our users to do the same. If you believe that any content on this Website infringes your copyright or trademark, please send a written notice to our Grievance Officer (see <a href="/terms-of-service">Terms of Service</a> for contact details) with the following information:</p>
                <ul>
                    <li>Identification of the copyrighted work claimed to have been infringed.</li>
                    <li>Identification of the material that is claimed to be infringing (URL or description).</li>
                    <li>Your contact information, signature, and a statement of good faith belief.</li>
                </ul>
                <p>We will investigate and take appropriate action under applicable laws, including removal of infringing material.</p>
            </div>
        </div>

        <!-- Summary Statement -->
        <div style="background: #eef3fa; border-radius: 24px; padding: 1.2rem 1.8rem; margin-top: 1rem; text-align: center; border: 1px solid #cfdfef;">
            <p style="font-weight: 500;">📌 <strong>By using Sarkariresult.mobi, you acknowledge that you have read, understood, and agreed to this Disclaimer.</strong> We are an independent information platform and not affiliated with any government organization unless explicitly stated. Always refer to official sources for authoritative information regarding exams, results, and recruitment.</p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p style="margin-top: 12px; font-size: 0.7rem;">This website uses cookies to enhance user experience. By continuing, you agree to our cookie policy. We are not responsible for any loss or damage arising from the use of information on this site.</p>
    </footer>
</div>

@endsection