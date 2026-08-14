// assets/js/dynamic-jsonld.js

class DynamicJSONLD {
    constructor(config) {
        this.siteConfig = {
            name: config.siteName || 'SarkariResult.Mobi',
            url: config.siteUrl || 'https://sarkariresult.mobi',
            logo: config.logoUrl || '/images/logo.png',
            description: config.description || 'India\'s No.1 job information portal'
        };
    }
    
    /**
     * Detect current page and generate appropriate schema
     */
    generate() {
        const path = window.location.pathname;
        const pageType = this.detectPageType(path);
        
        let schema = null;
        
        switch(pageType) {
            case 'home':
                schema = this.websiteSchema();
                break;
            case 'privacy-policy':
                schema = this.privacyPolicySchema();
                break;
            case 'terms-of-service':
                schema = this.termsOfServiceSchema();
                break;
            case 'disclaimer':
                schema = this.disclaimerSchema();
                break;
            case 'about':
                schema = this.aboutPageSchema();
                break;
            case 'contact':
                schema = this.contactPageSchema();
                break;
            case 'job':
                schema = this.jobPostingSchema(this.getPageData());
                break;
            case 'result':
                schema = this.resultSchema(this.getPageData());
                break;
            default:
                schema = this.webPageSchema();
        }
        
        if (schema) {
            this.injectSchema(schema);
        }
        
        // Also inject breadcrumb
        this.injectBreadcrumbSchema();
    }
    
    /**
     * Detect page type from URL
     */
    detectPageType(path) {
        if (path === '/' || path === '/index.html') return 'home';
        if (path.includes('privacy-policy')) return 'privacy-policy';
        if (path.includes('terms-of-service') || path.includes('terms')) return 'terms-of-service';
        if (path.includes('disclaimer')) return 'disclaimer';
        if (path.includes('about')) return 'about';
        if (path.includes('contact')) return 'contact';
        if (path.includes('latest-jobs') || path.includes('job')) return 'job';
        if (path.includes('result')) return 'result';
        if (path.includes('admit-card')) return 'admit-card';
        return 'webpage';
    }
    
    /**
     * Website Schema
     */
    websiteSchema() {
        return {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": this.siteConfig.name,
            "url": this.siteConfig.url,
            "description": this.siteConfig.description,
            "potentialAction": {
                "@type": "SearchAction",
                "target": `${this.siteConfig.url}/search?q={search_term_string}`,
                "query-input": "required name=search_term_string"
            }
        };
    }
    
    /**
     * Privacy Policy Schema
     */
    privacyPolicySchema() {
        return {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Privacy Policy",
            "description": `Official privacy policy of ${this.siteConfig.name} – covering data collection, cookies, GDPR rights, security measures, and grievance redressal.`,
            "url": `${this.siteConfig.url}/privacy-policy`,
            "dateModified": new Date().toISOString().split('T')[0],
            "publisher": this.organizationSchema()
        };
    }
    
    /**
     * Terms of Service Schema
     */
    termsOfServiceSchema() {
        return {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Terms of Service",
            "description": `Legal terms and conditions governing the use of ${this.siteConfig.name} website and services.`,
            "url": `${this.siteConfig.url}/terms-of-service`,
            "dateModified": new Date().toISOString().split('T')[0],
            "publisher": this.organizationSchema()
        };
    }
    
    /**
     * Disclaimer Schema
     */
    disclaimerSchema() {
        return {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Disclaimer",
            "description": `Legal disclaimer regarding the accuracy, completeness, and reliability of information published on ${this.siteConfig.name}.`,
            "url": `${this.siteConfig.url}/disclaimer`,
            "dateModified": new Date().toISOString().split('T')[0],
            "publisher": this.organizationSchema()
        };
    }
    
    /**
     * About Page Schema
     */
    aboutPageSchema() {
        return {
            "@context": "https://schema.org",
            "@type": "AboutPage",
            "name": "About Us",
            "description": `Learn about ${this.siteConfig.name} - our mission, vision, and team.`,
            "url": `${this.siteConfig.url}/about`,
            "publisher": this.organizationSchema()
        };
    }
    
    /**
     * Contact Page Schema
     */
    contactPageSchema() {
        return {
            "@context": "https://schema.org",
            "@type": "ContactPage",
            "name": "Contact Us",
            "description": `Get in touch with ${this.siteConfig.name} team for support, feedback, or inquiries.`,
            "url": `${this.siteConfig.url}/contact`,
            "mainEntity": {
                "@type": "ContactPoint",
                "contactType": "customer support",
                "email": "support@sarkariresult.mobi",
                "availableLanguage": ["English", "Hindi"]
            }
        };
    }
    
    /**
     * Job Posting Schema
     */
    jobPostingSchema(data) {
        return {
            "@context": "https://schema.org",
            "@type": "JobPosting",
            "title": data.title || document.querySelector('h1')?.innerText || '',
            "description": data.description || document.querySelector('meta[name="description"]')?.content || '',
            "datePosted": data.datePosted || new Date().toISOString().split('T')[0],
            "validThrough": data.lastDate || '',
            "hiringOrganization": {
                "@type": "Organization",
                "name": data.organization || '',
                "sameAs": data.orgWebsite || ''
            },
            "jobLocation": {
                "@type": "Place",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": data.location || "India",
                    "addressCountry": "IN"
                }
            }
        };
    }
    
    /**
     * Result Schema
     */
    resultSchema(data) {
        return {
            "@context": "https://schema.org",
            "@type": "EducationEvent",
            "name": data.examName || "Exam Result",
            "description": data.description || "Check your exam results and scorecard",
            "startDate": data.resultDate || new Date().toISOString().split('T')[0],
            "location": {
                "@type": "VirtualLocation",
                "url": window.location.href
            },
            "organizer": {
                "@type": "Organization",
                "name": data.organizer || ""
            }
        };
    }
    
    /**
     * Organization Schema
     */
    organizationSchema() {
        return {
            "@type": "Organization",
            "name": this.siteConfig.name,
            "alternateName": "Sarkari Result",
            "url": this.siteConfig.url,
            "logo": {
                "@type": "ImageObject",
                "url": `${this.siteConfig.url}${this.siteConfig.logo}`,
                "width": 200,
                "height": 60
            },
            "sameAs": [
                "https://www.facebook.com/SarkariResult.Mobi",
                "https://twitter.com/SarkariResult.Mobi",
                "https://www.instagram.com/sarkariresult.mobi"
            ]
        };
    }
    
    /**
     * Generic WebPage Schema
     */
    webPageSchema() {
        return {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": document.querySelector('title')?.innerText || '',
            "description": document.querySelector('meta[name="description"]')?.content || '',
            "url": window.location.href,
            "dateModified": new Date().toISOString().split('T')[0],
            "publisher": this.organizationSchema()
        };
    }
    
    /**
     * Breadcrumb Schema
     */
    breadcrumbSchema() {
        const breadcrumbs = this.generateBreadcrumbs();
        
        if (breadcrumbs.length <= 1) return null;
        
        const items = breadcrumbs.map((crumb, index) => ({
            "@type": "ListItem",
            "position": index + 1,
            "name": crumb.name,
            "item": crumb.url
        }));
        
        return {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": items
        };
    }
    
    /**
     * Generate breadcrumbs from URL
     */
    generateBreadcrumbs() {
        const path = window.location.pathname;
        const parts = path.split('/').filter(p => p && p !== '');
        const breadcrumbs = [{ name: 'Home', url: this.siteConfig.url }];
        
        let currentPath = '';
        for (let i = 0; i < parts.length; i++) {
            currentPath += '/' + parts[i];
            let name = parts[i].replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            
            // Custom names for specific pages
            const customNames = {
                'privacy-policy': 'Privacy Policy',
                'terms-of-service': 'Terms of Service',
                'latest-jobs': 'Latest Jobs'
            };
            
            name = customNames[parts[i]] || name;
            
            breadcrumbs.push({
                name: name,
                url: this.siteConfig.url + currentPath
            });
        }
        
        return breadcrumbs;
    }
    
    /**
     * Inject schema into page
     */
    injectSchema(schema) {
        const script = document.createElement('script');
        script.type = 'application/ld+json';
        script.textContent = JSON.stringify(schema, null, 2);
        document.head.appendChild(script);
    }
    
    /**
     * Inject breadcrumb schema
     */
    injectBreadcrumbSchema() {
        const breadcrumbSchema = this.breadcrumbSchema();
        if (breadcrumbSchema) {
            this.injectSchema(breadcrumbSchema);
        }
    }
    
    /**
     * Get page data from meta tags or data attributes
     */
    getPageData() {
        return {
            title: document.querySelector('meta[property="og:title"]')?.content || '',
            description: document.querySelector('meta[name="description"]')?.content || '',
            organization: document.querySelector('[data-organization]')?.getAttribute('data-organization') || '',
            lastDate: document.querySelector('[data-last-date]')?.getAttribute('data-last-date') || '',
            location: document.querySelector('[data-location]')?.getAttribute('data-location') || ''
        };
    }
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const jsonld = new DynamicJSONLD({
        siteName: 'SarkariResult.Mobi',
        siteUrl: 'https://sarkariresult.mobi',
        logoUrl: '/images/logo.png',
        description: 'India\'s No.1 job information portal for government exams, results, admit cards, and answer keys.'
    });
    
    jsonld.generate();
});