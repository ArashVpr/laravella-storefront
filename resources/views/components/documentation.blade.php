<x-app title="Documentation">
    <div
        style="max-width: 800px; margin: 40px auto; padding: 20px; font-family: sans-serif; line-height: 1.6; color: #333;">
        <h1 style="font-size: 32px; font-weight: bold; margin-bottom: 20px;">Documentation for car-hub.xyz</h1>

        <h2 style="font-size: 24px; font-weight: bold; margin-top: 30px;">Table of Contents</h2>
        <ul>
            <li><a href="#introduction">Introduction</a></li>
            <li><a href="#installation">Installation</a></li>
            <li><a href="#configuration">Configuration</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#database-structure">Database Structure</a></li>
            <li><a href="#factories-seeders">Factories and Seeders</a></li>
            <li><a href="#routes">Routes</a></li>
            <li><a href="#controllers">Controllers</a></li>
            <li><a href="#policies">Policies</a></li>
            <li><a href="#testing">Testing</a></li>
            <li><a href="#accessibility">Accessibility</a></li>
            <li><a href="#seo">SEO</a></li>
            <li><a href="#styling-frontend">Styling and Frontend</a></li>
            <li><a href="#third-party">Third-Party Integrations</a></li>
            <li><a href="#deployment">Deployment (with GitHub Actions)</a></li>
            <li><a href="#license">License</a></li>
        </ul>

        <h2 id="introduction" style="font-size: 20px; font-weight: bold; margin-top: 40px;">Introduction</h2>
        <p>car-hub.xyz is a Laravel-based web application designed for managing cars, their features, and user
            interactions such as watchlists and authentication. It leverages Laravel's built-in features like Eloquent
            ORM and Blade templates for authentication.</p>

        <h2 id="installation" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Installation</h2>
        <ul>
            <li>Clone the repository</li>
            <li>Install dependencies:
                <ul>
                    <li>Run <code>composer install</code></li>
                    <li>Run <code>npm install</code></li>
                </ul>
            </li>
            <li>Copy <code>.env.example</code> to <code>.env</code></li>
            <li>Generate the application key: <code>php artisan key:generate</code></li>
            <li>Configure your database in <code>.env</code> and run migrations: <code>php artisan migrate --seed</code>
            </li>
            <li>Build frontend assets: <code>npm run dev</code></li>
            <li>Start the development server: <code>php artisan serve</code></li>
        </ul>

        <h2 id="configuration" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Configuration</h2>
        <ul>
            <li><strong>Environment Variables:</strong> Configure the <code>.env</code> file for database, mail, and
                third-party services.</li>
            <li><strong>Queue Configuration:</strong> Update <code>queue.php</code> for queue drivers like Redis or
                database.</li>
            <li><strong>Authentication:</strong> Uses session-based login.</li>
        </ul>

        <h2 id="features" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Features</h2>
        <ul>
            <li><strong>Car Management:</strong>
                <ul>
                    <li>Add, edit, delete, and view cars.</li>
                    <li>Manage car features and images.</li>
                </ul>
            </li>
            <li><strong>User Authentication:</strong>
                <ul>
                    <li>Login, signup, and password reset.</li>
                    <li>OAuth login via Google and Facebook.</li>
                </ul>
            </li>
            <li><strong>Watchlist:</strong> Add or remove cars from the user's watchlist.</li>
            <li><strong>Profile Management:</strong> Update user profile and password.</li>
            <li><strong>Search and Filters:</strong> Search cars by maker, model, city, and other attributes.</li>
            <li><strong>Admin Panel:</strong> Manage users and cars via Filament Admin Panel.</li>
        </ul>

        <h2 id="database-structure" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Database Structure
        </h2>
        <p>Domain Tables:</p>
        <ul>
            <li><code>users</code>: Stores user information.</li>
            <li><code>cars</code>: Stores car details.</li>
            <li><code>car_features</code>: Stores features for each car.</li>
            <li><code>car_images</code>: Stores image paths for cars.</li>
            <li><code>favorite_cars</code>: Stores user watchlist data.</li>
            <li><code>makers</code>: Car manufacturers.</li>
            <li><code>models</code>: Car models, linked to makers.</li>
            <li><code>car_types</code>: Types of cars (e.g., sedan, SUV).</li>
            <li><code>fuel_types</code>: Types of fuel (e.g., petrol, diesel).</li>
            <li><code>cities</code>: Cities, linked to states.</li>
            <li><code>states</code>: States.</li>
        </ul>

        <h2 id="factories-seeders" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Factories and Seeders
        </h2>
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

        <h2 id="routes" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Routes</h2>
        <p><strong>Public Routes:</strong></p>
        <ul>
            <li><code>/</code>: Homepage.</li>
            <li><code>/car/search</code>: Search cars.</li>
            <li><code>/signup</code>: User signup.</li>
            <li><code>/login</code>: User login.</li>
        </ul>
        <p><strong>Authenticated Routes:</strong></p>
        <ul>
            <li><code>/car</code>: Manage cars.</li>
            <li><code>/watchlist</code>: View watchlist.</li>
            <li><code>/profile</code>: Manage profile.</li>
        </ul>
        <p>Routes are defined in:</p>
        <ul>
            <li><code>web.php</code></li>
            <li><code>auth.php</code></li>
        </ul>

        <h2 id="controllers" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Controllers</h2>
        <p><strong>Key Controllers:</strong></p>
        <ul>
            <li><strong>CarController:</strong> Handles car CRUD operations and features management.</li>
            <li><strong>SignupController:</strong> Manages user registration.</li>
            <li><strong>WatchlistController:</strong> Handles adding/removing cars to/from the watchlist.</li>
            <li><strong>ProfileController:</strong> Manages user profile updates and password changes.</li>
        </ul>

        <h2 id="policies" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Policies</h2>
        <p><strong>CarPolicy:</strong> Authorizes actions like creating, updating, and deleting cars.</p>

        <h2 id="testing" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Testing</h2>
        <p><strong>Feature Tests:</strong></p>
        <ul>
            <li><code>CarTest</code>: Tests car-related functionality.</li>
            <li><code>AuthTest</code>: Tests authentication.</li>
            <li><code>SignupTest</code>: Tests user signup.</li>
            <li><code>WatchlistTest</code>: Tests watchlist access and actions.</li>
            <li><code>ProfileTest</code>: Tests profile page access.</li>
            <li><code>PasswordResetTest</code>: Tests password reset flow.</li>
            <li><code>HomeTest</code>: Tests homepage car display.</li>
        </ul>
        <p>Run tests with: <code>php artisan test</code></p>

        <h2 id="accessibility" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Accessibility</h2>
        <ul>
            <li>Semantic HTML is used throughout the app for better screen reader support.</li>
            <li>Color contrast and font sizes are chosen for readability.</li>
            <li>Navigation is keyboard accessible.</li>
            <li>Forms use proper labels and error messages.</li>
            <li>Responsive design ensures usability on all devices.</li>
        </ul>

        <h2 id="seo" style="font-size: 20px; font-weight: bold; margin-top: 30px;">SEO Features</h2>
        <ul>
            <li>Dynamic page titles and meta descriptions for each page.</li>
            <li>Canonical URLs to prevent duplicate content issues.</li>
            <li>Open Graph and Twitter Card meta tags for rich social sharing.</li>
            <li>Responsive design for mobile-friendliness (important for SEO ranking).</li>
            <li>Clean, semantic HTML structure for better indexing.</li>
        </ul>

        <h2 id="styling-frontend" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Styling and Frontend
        </h2>
        <ul>
            <li><strong>CSS:</strong> Located in <code>app.css</code>.</li>
            <li><strong>JavaScript:</strong> Located in <code>app.js</code>.</li>
            {{-- <li><strong>Framework:</strong> TailwindCSS is used for styling.</li> --}}
        </ul>

        <h2 id="third-party" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Third-Party Integrations</h2>
        <ul>
            <li><strong>Socialite:</strong> Google and Facebook OAuth login. Configured in <code>services.php</code>.
            </li>
            <li><strong>Mailtrap:</strong> Used for email verification and testing email delivery (<a
                    href="https://mailtrap.io/" target="_blank">mailtrap.io</a>).</li>
        </ul>
        <h2 id="deployment" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Deployment (with GitHub
            Actions)</h2>
        <p>The application uses GitHub Actions for Continuous Integration and Deployment (CI/CD). The deployment process
            is automated and triggered on the creation of a new release.</p>

        <h3 style="font-weight: bold;">GitHub Actions Workflow</h3>
        <p>The deployment workflow is defined in <code>deploy.yml</code>.</p>

        <h3 style="font-weight: bold;">How It Works</h3>
        <ul>
            <li><strong>Trigger:</strong> The workflow is triggered when a new release is created in the GitHub
                repository.</li>
            <li><strong>Build Steps:</strong>
                <ul>
                    <li>The code is checked out.</li>
                    <li>PHP and Node.js environments are set up.</li>
                    <li>Dependencies are installed using Composer and npm.</li>
                    <li>Laravel-specific tasks like generating the encryption key, creating a storage link, and running
                        migrations are executed.</li>
                    <li>Frontend assets are built.</li>
                    <li>Tests are run to ensure the application is functioning correctly.</li>
                </ul>
            </li>
            <li><strong>Deployment:</strong> The app is deployed to the server using the
                <code>appleboy/ssh-action</code>. The server pulls the latest release tag, installs dependencies, builds
                assets, and optimizes the Laravel app.
            </li>
        </ul>

        <h2 id="license" style="font-size: 20px; font-weight: bold; margin-top: 30px;">License</h2>
        <p>This application is open-sourced software licensed under the MIT license.</p>
    </div>
</x-app>
