@extends('layouts.app')

@section('title', 'Privacy Policy - SarkariResult.Mobi')

@section('description', 'Read our comprehensive Privacy Policy to understand data collection, cookies, GDPR rights, and security measures.')

@php
    $pageType = 'privacy-policy';
    $pageTitle = 'Privacy Policy';
    $pageDescription = 'Official privacy policy of SarkariResult.Mobi';
@endphp

@push('jsonld')
    {!! \App\Services\StructuredDataGenerator::generate('privacy-policy', [
        'site_name' => 'SarkariResult.Mobi',
        'site_url' => 'https://sarkariresult.mobi',
        'date_published' => '2025-01-15',
        'date_modified' => now()->toDateString()
    ]) !!}
@endpush


@section('content')


<style>
       
        .containerpr {
            max-width: 1280px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 20px 35px -10px rgba(0,0,0,0.05);
        }
        /* header styles */
        .site-header {
            background: linear-gradient(135deg, #0f2b3d 0%, #1b4a6e 100%);
            color: white;
            padding: 1.2rem 2rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #f59e0b;
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logo-icon {
            background: white;
            border-radius: 18px;
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: bold;
            color: #0f2b3d;
        }
        .site-title h1 {
            font-size: 1.8rem;
            letter-spacing: -0.5px;
        }
        .site-title p {
            font-size: 0.85rem;
            opacity: 0.85;
        }
        .nav-links {
            display: flex;
            gap: 1.2rem;
            flex-wrap: wrap;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 40px;
            transition: 0.2s;
        }
        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }
        /* main content */
        .privacy-content {
            padding: 2rem 2rem 3rem;
        }
        .page-heading {
            border-left: 6px solid #f59e0b;
            padding-left: 20px;
            margin-bottom: 2rem;
        }
        .page-heading h2 {
            font-size: 2.3rem;
            color: #0c4a6e;
            font-weight: 700;
        }
        .page-heading .last-updated {
            color: #475569;
            margin-top: 8px;
            font-size: 0.9rem;
        }
        .policy-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
            border: 1px solid #e9eef3;
            overflow: hidden;
        }
        .policy-card h3 {
            background: #f1f5f9;
            padding: 1rem 1.5rem;
            font-size: 1.5rem;
            color: #0f3b5c;
            border-bottom: 2px solid #e2e8f0;
        }
        .policy-card .card-body {
            padding: 1.5rem;
        }
        .policy-card ul, .policy-card ol {
            padding-left: 1.8rem;
            margin: 0.8rem 0;
        }
        .policy-card li {
            margin: 0.6rem 0;
            font-size: 1rem;
        }
        .badge-law {
            background: #eef2ff;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-right: 8px;
        }
        .highlight {
            background: #fef9e3;
            padding: 1rem;
            border-left: 4px solid #f59e0b;
            margin: 1.2rem 0;
            border-radius: 12px;
        }
        .grievance-box {
            background: #f0f9ff;
            border-radius: 20px;
            padding: 1.2rem;
            margin-top: 1rem;
            border: 1px solid #b9d9f0;
        }
        footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 2rem;
            text-align: center;
            font-size: 0.85rem;
            border-top: 1px solid #1e293b;
        }
        footer a {
            color: #facc15;
            text-decoration: none;
        }
        @media (max-width: 780px) {
            .site-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            .privacy-content {
                padding: 1.5rem;
            }
            .page-heading h2 {
                font-size: 1.8rem;
            }
            .policy-card h3 {
                font-size: 1.3rem;
            }
        }
        hr {
            margin: 1rem 0;
        }
        .table-of-contents {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
        }
        .table-of-contents a {
            background: white;
            padding: 5px 14px;
            border-radius: 40px;
            text-decoration: none;
            color: #1e40af;
            font-size: 0.85rem;
            border: 1px solid #dce3ec;
            transition: 0.1s;
        }
        .table-of-contents a:hover {
            background: #e6edf6;
            border-color: #94a3b8;
        }
        .green-tick {
            color: #15803d;
        }
    </style>

<div class="containerpr">
    <!-- Header Section -->
    <header class="site-header">
        <div class="logo-area">
            <div class="logo-icon">SR</div>
            <div class="site-title">
                <h1>SarkariResult.Mobi</h1>
                <p>Trust & Transparency First</p>
            </div>
        </div>
    </header>

    <!-- Main Privacy Content -->
    <div class="privacy-content">
        <div class="page-heading">
            <h2>Privacy Policy</h2>
            <div class="last-updated"><strong>Effective from:</strong> April 2, 2026 | <strong>Last revised:</strong> April 2, 2026</div>
        </div>

        <!-- Quick TOC -->
        <div class="table-of-contents">
            <a href="#intro">📌 Introduction</a>
            <a href="#data-we-collect">📊 Data Collection</a>
            <a href="#legal-basis">⚖️ Legal Basis (GDPR/CCPA)</a>
            <a href="#cookies">🍪 Cookies & Tracking</a>
            <a href="#thirdparty">🔗 Third-Party Links</a>
            <a href="#security">🔒 Security Measures</a>
            <a href="#your-rights">🛡️ Your Rights</a>
            <a href="#grievance">📞 Grievance Officer</a>
        </div>

        <!-- Introduction Card -->
        <div class="policy-card" id="intro">
            <h3>1. Introduction & Scope</h3>
            <div class="card-body">
                <p><span class="badge-law">IT Act 2000 (India)</span> <span class="badge-law">GDPR (EU)</span> <span class="badge-law">CCPA (California)</span></p>
                <p>Welcome to SarkariResult.Mobi (referred to as "Company", "we", "us", or "our"). This Privacy Policy describes how we collect, use, share, and protect your personal information when you visit our website <strong>https://sarkariresult.mobi</strong> or use any of our services, mobile applications, or other online platforms (collectively, "Services").</p>
                <p>We are committed to protecting your privacy and handling your data in an open and transparent manner. This policy applies to all users, visitors, and customers. By accessing our Services, you acknowledge the practices described herein. If you disagree with any part, please discontinue using our platform.</p>
                <div class="highlight">
                    ✅ <strong>Key principle:</strong> We never sell your personal data to third parties for marketing purposes. Your trust is our priority.
                </div>
                <p>We may update this policy from time to time to reflect legal changes or operational improvements. Significant changes will be notified via email (if registered) or a prominent notice on our website.</p>
            </div>
        </div>

        <!-- Data We Collect -->
        <div class="policy-card" id="data-we-collect">
            <h3>2. What Information We Collect</h3>
            <div class="card-body">
                <p>We collect information to provide better services to all our users. The categories of data include:</p>
                <ul>
                    <li><strong>Personal Identifiable Information (PII):</strong> Name, email address, phone number (only if you voluntarily provide via contact forms, newsletter signups, or account creation).</li>
                    <li><strong>Automatically Collected Data:</strong> IP address, browser type, operating system, device identifiers, referring URLs, pages visited, date/time stamps, and clickstream data.</li>
                    <li><strong>Cookies & Similar Technologies:</strong> We use cookies to remember preferences, analyze traffic, and improve user experience (see section 4).</li>
                    <li><strong>Usage Data:</strong> How you interact with our platform, search queries, download history, and feature interactions.</li>
                    <li><strong>No Special Categories:</strong> We do not intentionally collect sensitive personal data (e.g., health, biometrics, political opinions) unless explicitly provided by you for a specific service and with your consent.</li>
                </ul>
                <p><strong>Children's Privacy:</strong> Our Services are not directed to individuals under the age of 13. We do not knowingly collect personal information from children. If you believe a child has provided us with data, please contact us immediately for removal.</p>
            </div>
        </div>

        <!-- Legal Basis GDPR -->
        <div class="policy-card" id="legal-basis">
            <h3>3. Legal Basis for Processing (GDPR & Global Compliance)</h3>
            <div class="card-body">
                <p>For users located in the European Economic Area (EEA), United Kingdom, or Switzerland, we process your personal data only when we have a valid legal basis under Article 6 of the GDPR:</p>
                <ul>
                    <li><span class="green-tick">✔</span> <strong>Consent:</strong> You have given clear consent for us to process your data for a specific purpose (e.g., newsletter).</li>
                    <li><span class="green-tick">✔</span> <strong>Contractual necessity:</strong> Processing is necessary for a contract or to take steps at your request before entering a contract.</li>
                    <li><span class="green-tick">✔</span> <strong>Legal obligation:</strong> Compliance with a legal or regulatory obligation.</li>
                    <li><span class="green-tick">✔</span> <strong>Legitimate interests:</strong> We may process data where it serves our legitimate interests (e.g., improving security, analytics) without overriding your rights.</li>
                </ul>
                <p>For residents of California (CCPA), you have the right to know what personal information is collected, request deletion, and opt-out of "sales" (we do not sell your data). For more details, see Section 7.</p>
            </div>
        </div>

        <!-- Cookies & Tracking -->
        <div class="policy-card" id="cookies">
            <h3>4. Cookies, Web Beacons & Analytics</h3>
            <div class="card-body">
                <p>We use first-party and third-party cookies to enhance functionality, analyze site usage, and serve relevant advertisements (where applicable). Types of cookies we use:</p>
                <ul>
                    <li><strong>Essential Cookies:</strong> Required for basic website functions (e.g., security, load balancing).</li>
                    <li><strong>Analytics/Performance Cookies:</strong> Google Analytics, Microsoft Clarity, or similar to understand user behavior and improve content.</li>
                    <li><strong>Functionality Cookies:</strong> Remember your preferences and login status.</li>
                    <li><strong>Advertising Cookies:</strong> Third-party vendors like Google AdSense may use cookies to serve ads based on prior visits to our site. You can opt out of personalized advertising via Google Ad Settings: <a href="#" target="_blank" rel="noopener noreferrer">https://adssettings.google.com</a>.</li>
                </ul>
                <p>You can control cookies through your browser settings. However, disabling certain cookies may affect the functionality of our website. For more detailed cookie information, see our <a href="#cookie-policy">Cookie Policy</a>.</p>
                <div class="highlight">
                    🍪 <strong>Third-Party Ad Partners:</strong> We may work with ad networks such as Google, Media.net, or others. These partners have their own privacy policies. We recommend reviewing them.
                </div>
            </div>
        </div>

        <!-- Third-Party Links -->
        <div class="policy-card" id="thirdparty">
            <h3>5. Links to Third-Party Websites & Services</h3>
            <div class="card-body">
                <p>Our platform may contain links to external websites, plugins, or applications (e.g., job portals, educational resources). Once you click those links and leave our domain, this Privacy Policy no longer applies. We are not responsible for the privacy practices of third-party sites. We encourage you to read their policies before sharing any personal information.</p>
                <p>Furthermore, we integrate with social media features (like, share) that may collect your IP address and set cookies. Interactions are governed by the respective social network's privacy policy.</p>
            </div>
        </div>

        <!-- Security Measures -->
        <div class="policy-card" id="security">
            <h3>6. How We Protect Your Information</h3>
            <div class="card-body">
                <p>We implement industry-standard security measures to safeguard your data against unauthorized access, alteration, disclosure, or destruction. These include:</p>
                <ul>
                    <li><strong>Encryption:</strong> TLS 1.3 encryption for data in transit. Sensitive data stored at rest is encrypted (AES-256).</li>
                    <li><strong>Access Controls:</strong> Strict internal access to personal data is limited to authorized personnel only.</li>
                    <li><strong>Regular Audits:</strong> Vulnerability scanning, penetration testing, and continuous monitoring.</li>
                    <li><strong>Secure Hosting:</strong> Cloud infrastructure with firewalls, DDoS protection, and automated backups (AWS/GCP).</li>
                </ul>
                <p>While we strive for complete security, no method of transmission over the Internet is 100% secure. We cannot guarantee absolute security, but we commit to prompt notification in the event of a data breach as required by applicable laws.</p>
            </div>
        </div>

        <!-- Your Rights Section -->
        <div class="policy-card" id="your-rights">
            <h3>7. Your Data Protection Rights (GDPR, CCPA, LGPD)</h3>
            <div class="card-body">
                <p>Depending on your jurisdiction, you may have the following rights regarding your personal data:</p>
                <ul>
                    <li><strong>Right to Access:</strong> Request a copy of the personal data we hold about you.</li>
                    <li><strong>Right to Rectification:</strong> Correct inaccurate or incomplete data.</li>
                    <li><strong>Right to Erasure ("Right to be Forgotten"):</strong> Request deletion of your personal data under certain conditions.</li>
                    <li><strong>Right to Restrict Processing:</strong> Limit how we use your data.</li>
                    <li><strong>Right to Data Portability:</strong> Receive your data in a structured, machine-readable format.</li>
                    <li><strong>Right to Object:</strong> Object to processing based on legitimate interests or direct marketing.</li>
                    <li><strong>Right to Withdraw Consent:</strong> Withdraw previously given consent at any time.</li>
                </ul>
                <p>To exercise any of these rights, please contact our Data Protection team at <strong>privacy@sarkariresult.mobi</strong>. We will respond within 30 days. No fee will be charged unless the request is excessive or unfounded.</p>
                <div class="grievance-box">
                    <p><strong>California Residents (CCPA):</strong> You have the right to opt-out of the sale of personal information. We do not sell personal data. However, you may request disclosure of categories of information collected and business purposes. Email us with "CCPA Request" in the subject line.</p>
                </div>
            </div>
        </div>

        <!-- Data Retention -->
        <div class="policy-card">
            <h3>8. Data Retention Policy</h3>
            <div class="card-body">
                <p>We retain personal data only for as long as necessary to fulfill the purposes outlined in this policy, unless a longer retention period is required by law (e.g., tax, legal dispute). Criteria used to determine retention periods include:</p>
                <ul>
                    <li>Length of active relationship with you (if any).</li>
                    <li>Legal or regulatory obligations (e.g., records for financial compliance).</li>
                    <li>Statute of limitations for potential claims.</li>
                </ul>
                <p>After retention expiry, your data will be securely anonymized or deleted from our active systems and backups.</p>
            </div>
        </div>

        <!-- International Data Transfer -->
        <div class="policy-card">
            <h3>9. International Data Transfers</h3>
            <div class="card-body">
                <p>Your information may be transferred to, stored, and processed in countries other than your own, including India and the United States. We ensure appropriate safeguards (Standard Contractual Clauses, adequacy decisions) are in place for cross-border data transfers in compliance with GDPR and other applicable laws. By using our Services, you consent to such transfers.</p>
            </div>
        </div>

        <!-- Grievance Redressal -->
        <div class="policy-card" id="grievance">
            <h3>10. Grievance Officer & Contact Information</h3>
            <div class="card-body">
                <p>In compliance with the Information Technology Act, 2000 and its associated rules, we have appointed a Grievance Officer to address any concerns regarding privacy, data misuse, or policy violations. You may reach out via:</p>
                <div class="grievance-box">
                    <p><strong>Grievance Officer:</strong> Ms. Neha Sharma (Compliance & Data Protection)<br>
                    <strong>Email:</strong> grievance@sarkariresult.mobi  |  <strong>Alternate:</strong> legal@sarkariresult.mobi<br>
                    <strong>Postal Address:</strong> SarkariResult.Mobi Legal Dept., 4th Floor, Cyber Heights, New Delhi - 110001, India<br>
                    <strong>Response Time:</strong> Acknowledgment within 24 hours; resolution within 30 days.</p>
                </div>
                <p>For general privacy inquiries, write to: <strong>privacy@sarkariresult.mobi</strong></p>
            </div>
        </div>

        <!-- Consent and Updates -->
        <div class="policy-card">
            <h3>11. Your Consent & Policy Changes</h3>
            <div class="card-body">
                <p>By using our website, you consent to the collection and use of your information as described in this Privacy Policy. If we decide to change our policy, we will post the revised version here with an updated "last revised" date. We encourage you to review this page periodically. In case of material modifications, we may provide additional notice (e.g., pop-up notice or email).</p>
                <p><strong>Questions?</strong> If you have any concerns about our privacy practices, please contact our support team before using the platform further.</p>
                <hr>
                <p style="font-size: 0.85rem; color: #475569;">This Privacy Policy is an electronic record under the Information Technology Act, 2000 and does not require any physical or digital signature. It is published in accordance with Rule 3 (1) of the Information Technology (Intermediary Guidelines and Digital Media Ethics Code) Rules, 2021.</p>
            </div>
        </div>
    </div>
</div>


@endsection  <!-- This MUST be here -->