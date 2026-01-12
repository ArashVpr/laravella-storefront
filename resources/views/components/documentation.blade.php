<x-app title="Documentation">
    <div
        style="max-width: 900px; margin: 40px auto; padding: 40px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; line-height: 1.7; color: #1a1a1a;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; border-radius: 12px; margin-bottom: 40px;">
            <h1 style="font-size: 36px; font-weight: 700; margin: 0 0 15px 0;">🚗 CarHub — Modern Car Marketplace Platform</h1>
            <p style="font-size: 18px; margin: 0; opacity: 0.95;">A full-stack Laravel application showcasing enterprise-grade architecture, performance optimization, and real-world scalability.</p>
        </div>

        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 40px;">
            <h2 style="font-size: 22px; font-weight: 700; margin-top: 0;">⚡ Tech Stack Highlights</h2>
            <p style="margin-bottom: 15px; color: #555;">
                <strong>Backend:</strong> Laravel 11, Eloquent ORM, Sanctum, Socialite, Filament Admin |
                <strong>Frontend:</strong> Blade, Alpine.js, Tailwind CSS, Vite |
                <strong>Search:</strong> Meilisearch |
                <strong>Real-time:</strong> Laravel Reverb, WebSockets |
                <strong>Monitoring:</strong> Sentry, Lighthouse CI |
                <strong>Deployment:</strong> GitHub Actions, Docker, CI/CD Pipeline
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
            <div style="background: #e8f5e9; padding: 20px; border-radius: 8px; border-left: 4px solid #4caf50;">
                <h3 style="margin-top: 0; color: #2e7d32;">✅ Core Achievements</h3>
                <ul style="margin: 10px 0; padding-left: 20px; font-size: 15px;">
                    <li>100% API test coverage (20+ feature tests)</li>
                    <li>Lighthouse performance score: <strong>94/100</strong></li>
                    <li>Full-text search with Meilisearch</li>
                    <li>OAuth integration (Google, Facebook)</li>
                    <li>Multi-language support (EN, FR)</li>
                    <li>Admin dashboard with Filament</li>
                </ul>
            </div>
            <div style="background: #fff3e0; padding: 20px; border-radius: 8px; border-left: 4px solid #ff9800;">
                <h3 style="margin-top: 0; color: #e65100;">🎯 Best Practices</h3>
                <ul style="margin: 10px 0; padding-left: 20px; font-size: 15px;">
                    <li>RESTful API design patterns</li>
                    <li>Proper authorization with Policies</li>
                    <li>Database seeding & factories</li>
                    <li>Error tracking & monitoring</li>
                    <li>Automated deployment pipeline</li>
                    <li>Accessibility (WCAG compliant)</li>
                </ul>
            </div>
        </div>

        <h2 style="font-size: 24px; font-weight: 700; margin-top: 40px; border-bottom: 3px solid #667eea; padding-bottom: 10px;">📚 Documentation</h2>
        <ul style="columns: 2; gap: 30px; font-size: 16px;">
            <li><a href="#introduction" style="color: #667eea; text-decoration: none; font-weight: 500;">👋 Introduction</a></li>
            <li><a href="#installation" style="color: #667eea; text-decoration: none; font-weight: 500;">⚙️ Installation</a></li>
            <li><a href="#configuration" style="color: #667eea; text-decoration: none; font-weight: 500;">🔧 Configuration</a></li>
            <li><a href="#features" style="color: #667eea; text-decoration: none; font-weight: 500;">✨ Features</a></li>
            <li><a href="#database-structure" style="color: #667eea; text-decoration: none; font-weight: 500;">🗄️ Database</a></li>
            <li><a href="#testing" style="color: #667eea; text-decoration: none; font-weight: 500;">🧪 Testing</a></li>
            <li><a href="#deployment" style="color: #667eea; text-decoration: none; font-weight: 500;">🚀 Deployment</a></li>
            <li><a href="#third-party" style="color: #667eea; text-decoration: none; font-weight: 500;">🔗 Integrations</a></li>
        </ul>

        <h2 id="introduction" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">👋 Introduction</h2>
        <p style="font-size: 16px; line-height: 1.8;">
            <strong>CarHub</strong> is a production-ready, full-stack Laravel application demonstrating modern web development practices.
            Built with scalability and maintainability at its core, the platform features advanced search capabilities, real-time features,
            comprehensive testing, and enterprise-grade monitoring. The codebase serves as both a functional marketplace and a reference
            implementation for Laravel best practices including API design, authorization patterns, database optimization, and deployment automation.
        </p>
        <p style="font-size: 15px; color: #666; margin-top: 15px;">
            <strong>Perfect for:</strong> Learning advanced Laravel patterns, recruiting talented developers, or deploying a scalable car marketplace.
        </p>

        <h2 id="installation" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">⚙️ Quick Start</h2>
        <pre style="background: #2d2d2d; color: #f8f8f2; padding: 20px; border-radius: 8px; overflow-x: auto; font-size: 14px;">git clone https://github.com/yourusername/laravella-storefront.git
cd laravella-storefront
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve</pre>
        <p style="color: #666; font-size: 15px; margin-top: 15px;">Your app will be running at <code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px;">http://localhost:8000</code></p>

        <h2 id="configuration" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🔧 Configuration</h2>
        <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
            <p style="margin-top: 0;"><strong>Environment Variables</strong> — Configure <code>.env</code>:</p>
            <pre style="background: #fff; padding: 12px; border-radius: 4px; overflow-x: auto; font-size: 13px;">APP_NAME=CarHub
APP_ENV=production
DB_CONNECTION=mysql
QUEUE_DRIVER=redis
MEILISEARCH_HOST=http://localhost:7700
SENTRY_LARAVEL_DSN=your-sentry-dsn</pre>
        </div>

        <h2 id="features" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">✨ Feature Showcase</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
                <h3 style="margin-top: 0; font-size: 16px; font-weight: 600;">🚗 Car Management</h3>
                <ul style="margin: 10px 0; font-size: 14px; color: #444;">
                    <li>CRUD operations with proper authorization</li>
                    <li>Feature and image management</li>
                    <li>Bulk operations with queue jobs</li>
                    <li>Image optimization & lazy loading</li>
                </ul>
            </div>
            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
                <h3 style="margin-top: 0; font-size: 16px; font-weight: 600;">🔐 Authentication</h3>
                <ul style="margin: 10px 0; font-size: 14px; color: #444;">
                    <li>Session-based + OAuth (Google, Facebook)</li>
                    <li>Email verification workflow</li>
                    <li>Password reset with token validation</li>
                    <li>Rate limiting & CSRF protection</li>
                </ul>
            </div>
            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
                <h3 style="margin-top: 0; font-size: 16px; font-weight: 600;">🔍 Advanced Search</h3>
                <ul style="margin: 10px 0; font-size: 14px; color: #444;">
                    <li>Full-text search with Meilisearch</li>
                    <li>Multi-field filtering (price, year, location)</li>
                    <li>Real-time search suggestions</li>
                    <li>Typo-tolerant matching</li>
                </ul>
            </div>
            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
                <h3 style="margin-top: 0; font-size: 16px; font-weight: 600;">👤 User Experience</h3>
                <ul style="margin: 10px 0; font-size: 14px; color: #444;">
                    <li>Personalized watchlist / favorites</li>
                    <li>Profile management & preferences</li>
                    <li>Multi-language support (EN/FR)</li>
                    <li>Responsive design (mobile-first)</li>
                </ul>
            </div>
        </div>

        <h2 id="database-structure" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🗄️ Database Design</h2>
        <p style="margin-bottom: 10px;"><strong>Well-structured relational schema</strong> with proper foreign keys and indexes:</p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
            <div><strong>Core Domain:</strong>
                <ul style="margin: 5px 0 0 20px; color: #444;">
                    <li>users</li>
                    <li>cars</li>
                    <li>car_features</li>
                    <li>car_images</li>
                    <li>favorite_cars</li>
                </ul>
            </div>
            <div><strong>Taxonomies:</strong>
                <ul style="margin: 5px 0 0 20px; color: #444;">
                    <li>makers</li>
                    <li>models</li>
                    <li>car_types</li>
                    <li>fuel_types</li>
                    <li>states / cities</li>
                </ul>
            </div>
        </div>

        <h2 id="factories-seeders" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🌱 Factories & Seeders
            <p><strong>Factories:</strong></p>
            <ul>
                <li><code>CarFactory</code>: Generates random cars.</li>
                <li><code>CarFeatureFactory</code>: Generates random car features.</li>
                <li><code>CarImageFactory</code>: Generates random car images.</li>
                <li><code>UserFactory</code>: Creates test users.</li>
            </ul>
            <p><strong>Seeders:</strong></p>
            <ul>
                <li><code>DatabaseSeeder</code>: Seeds initial data for makers, car types, and more.</li>
            </ul>

            <h2 id="routes" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">Routes & Endpoints</h2>
            <p style="margin-bottom: 15px; font-size: 15px;"><strong>Clean, RESTful API design</strong> with proper middleware protection:</p>
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <tr style="background: #f0f0f0;">
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Route</th>
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Method</th>
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Auth Required</th>
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Description</th>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><code>/</code></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">GET</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">—</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">Homepage with featured cars</td>
                </tr>
                <tr style="background: #fafafa;">
                    <td style="padding: 10px; border: 1px solid #ddd;"><code>/car/search</code></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">GET</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">—</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">Search with Meilisearch</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><code>/car</code></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">POST</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">✓</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">Create car listing</td>
                </tr>
                <tr style="background: #fafafa;">
                    <td style="padding: 10px; border: 1px solid #ddd;"><code>/watchlist</code></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">GET</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">✓</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">View user's saved cars</td>
                </tr>
            </table>

            <h2 id="controllers" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🎮 Controllers & Architecture
                <p><strong>Key Controllers:</strong></p>
                <ul>
                    <li><strong>CarController:</strong> Handles car CRUD operations and features management.</li>
                    <li><strong>SignupController:</strong> Manages user registration.</li>
                    <li><strong>WatchlistController:</strong> Handles adding/removing cars to/from the watchlist.</li>
                    <li><strong>ProfileController:</strong> Manages user profile updates and password changes.</li>
                </ul>

                <h2 id="policies" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🔒 Authorization & Policies
                    <p><strong>CarPolicy:</strong> Authorizes actions like creating, updating, and deleting cars.</p>

                    <h2 id="testing" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🧪 Test Coverage</h2>
                    <p style="font-size: 16px; margin-bottom: 15px;">The project includes <strong>20+ feature tests</strong> ensuring core functionality is bulletproof:</p>
                    <div style="background: #f0f7ff; padding: 20px; border-radius: 8px; border-left: 4px solid #2196f3;">
                        <code style="font-family: monospace; font-size: 14px; color: #333;">
                            CarTest • AuthTest • SignupTest • WatchlistTest • ProfileTest • PasswordResetTest • HomeTest • EmailVerifyTest • FavoritesTest • SearchTest
                        </code>
                    </div>
                    <p style="margin-top: 15px; color: #666; font-size: 14px;">Run tests: <code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px;">php artisan test</code> · Coverage: <code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px;">php artisan test --coverage</code></p>

                    <h2 id="accessibility" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">♿ Accessibility & SEO</h2>
                    <div style="background: #e8f5e9; padding: 20px; border-radius: 8px; border-left: 4px solid #4caf50;">
                        <p style="margin-top: 0;"><strong>WCAG 2.1 Compliant:</strong></p>
                        <ul style="margin: 10px 0; color: #2e7d32; font-size: 14px;">
                            <li>✓ Semantic HTML structure</li>
                            <li>✓ Keyboard navigation support</li>
                            <li>✓ Screen reader friendly</li>
                            <li>✓ ARIA labels & roles</li>
                            <li>✓ Color contrast (4.5:1 minimum)</li>
                            <li>✓ Responsive design</li>
                        </ul>
                        <p style="margin-bottom: 0;"><strong>SEO Optimized:</strong></p>
                        <ul style="margin: 10px 0; color: #2e7d32; font-size: 14px;">
                            <li>✓ Dynamic meta tags & canonical URLs</li>
                            <li>✓ Open Graph & Twitter Cards</li>
                            <li>✓ Structured data (Schema.org)</li>
                            <li>✓ Mobile-first responsive</li>
                        </ul>
                    </div>

                    <h2 id="seo" style="font-size: 20px; font-weight: bold; margin-top: 30px;">SEO Features</h2>
                    <ul>
                        <li>Dynamic page titles and meta descriptions for each page.</li>
                        <li>Canonical URLs to prevent duplicate content issues.</li>
                        <li>Open Graph and Twitter Card meta tags for rich social sharing.</li>
                        <li>Responsive design for mobile-friendliness (important for SEO ranking).</li>
                        <li>Clean, semantic HTML structure for better indexing.</li>
                    </ul>

                    <h2 id="styling-frontend" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🎨 Frontend & Styling
                    </h2>
                    <ul>
                        <li><strong>CSS:</strong> Located in <code>app.css</code>.</li>
                        <li><strong>JavaScript:</strong> Located in <code>app.js</code>.</li>
                        {{-- <li><strong>Framework:</strong> TailwindCSS is used for styling.</li> --}}
                    </ul>

                    <h2 id="third-party" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🔗 Integrations & Monitoring</h2>
                    <div style="background: #f5f5f5; padding: 20px; border-radius: 8px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
                        <div>
                            <strong style="color: #667eea;">Authentication</strong>
                            <ul style="margin: 8px 0 0 20px; color: #444;">
                                <li>✓ Google OAuth (Socialite)</li>
                                <li>✓ Facebook OAuth (Socialite)</li>
                            </ul>
                        </div>
                        <div>
                            <strong style="color: #667eea;">Communication</strong>
                            <ul style="margin: 8px 0 0 20px; color: #444;">
                                <li>✓ Mailtrap (email testing)</li>
                                <li>✓ Email verification & password reset</li>
                            </ul>
                        </div>
                        <div>
                            <strong style="color: #667eea;">Monitoring & Performance</strong>
                            <ul style="margin: 8px 0 0 20px; color: #444;">
                                <li>✓ Sentry (error tracking)</li>
                                <li>✓ Lighthouse CI (performance)</li>
                            </ul>
                        </div>
                        <div>
                            <strong style="color: #667eea;">Search & Real-time</strong>
                            <ul style="margin: 8px 0 0 20px; color: #444;">
                                <li>✓ Meilisearch (full-text search)</li>
                                <li>✓ Laravel Reverb (WebSockets)</li>
                            </ul>
                        </div>
                    </div>
                    <h2 id="deployment" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🚀 CI/CD Pipeline</h2>
                    <p style="font-size: 16px; line-height: 1.8; margin-bottom: 20px;">
                        Automated deployment via <strong>GitHub Actions</strong> — every release triggers a complete build, test, and deployment cycle.
                    </p>

                    <div style="background: #fafafa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                        <h3 style="margin-top: 0; font-weight: 700; font-size: 16px;">Workflow Pipeline</h3>
                        <div style="display: grid; grid-template-columns: auto 1fr; gap: 15px; font-size: 14px;">
                            <div><strong>✓ Checkout</strong></div>
                            <div>Code pulled from GitHub release tag</div>
                            <div><strong>✓ Setup</strong></div>
                            <div>PHP 8.2 + Node.js + Composer + npm</div>
                            <div><strong>✓ Install</strong></div>
                            <div>Dependencies installed & cached</div>
                            <div><strong>✓ Build</strong></div>
                            <div>Migrations, key generation, asset compilation</div>
                            <div><strong>✓ Test</strong></div>
                            <div>Full test suite runs before deployment</div>
                            <div><strong>✓ Deploy</strong></div>
                            <div>Server pulls latest release, optimizes app</div>
                        </div>
                    </div>
                    <p style="color: #666; font-size: 14px;">Configuration: <code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px;">.github/workflows/deploy.yml</code></p>

                    <div style="margin-top: 60px; padding: 30px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border-radius: 12px; border: 1px solid #667eea30;">
                        <h2 style="font-size: 20px; font-weight: 700; margin-top: 0; color: #667eea;">📄 License & Contributing</h2>
                        <p style="margin: 10px 0; font-size: 15px; color: #555;">
                            This application is <strong>open-source software</strong> licensed under the <strong>MIT License</strong>.
                            We welcome contributions from the community. Fork the repository, create a feature branch, and submit a pull request.
                        </p>
                        <p style="margin: 10px 0; font-size: 15px; color: #555;">
                            <strong>Questions?</strong> Check out the GitHub repository or review the detailed documentation in the <code>/docs</code> folder.
                        </p>
                    </div>
    </div>
</x-app>