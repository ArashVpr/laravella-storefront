<x-app title="Documentation">
    <div
        style="max-width: 900px; margin: 40px auto; padding: 40px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; line-height: 1.7; color: #1a1a1a;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; border-radius: 12px; margin-bottom: 40px;">
            <h1 style="font-size: 36px; font-weight: 700; margin: 0 0 15px 0;">🚗 CarHub — Plateforme Moderne de Marché Automobile</h1>
            <p style="font-size: 18px; margin: 0; opacity: 0.95;">Une application Laravel full-stack démontrant une architecture de niveau entreprise, l'optimisation des performances et l'évolutivité du monde réel.</p>
        </div>

        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 40px;">
            <h2 style="font-size: 22px; font-weight: 700; margin-top: 0;">⚡ Faits Saillants de la Pile Technologique</h2>
            <p style="margin-bottom: 15px; color: #555;">
                <strong>Backend :</strong> Laravel 11, Eloquent ORM, Sanctum, Socialite, Filament Admin |
                <strong>Frontend :</strong> Blade, Alpine.js, Tailwind CSS, Vite |
                <strong>Recherche :</strong> Meilisearch |
                <strong>Temps réel :</strong> Laravel Reverb, WebSockets |
                <strong>Surveillance :</strong> Sentry, Lighthouse CI |
                <strong>Déploiement :</strong> GitHub Actions, Docker, Pipeline CI/CD
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
            <div style="background: #e8f5e9; padding: 20px; border-radius: 8px; border-left: 4px solid #4caf50;">
                <h3 style="margin-top: 0; color: #2e7d32;">✅ Réalisations Principales</h3>
                <ul style="margin: 10px 0; padding-left: 20px; font-size: 15px;">
                    <li>100% couverture de test API (20+ tests fonctionnels)</li>
                    <li>Score de performance Lighthouse : <strong>94/100</strong></li>
                    <li>Recherche en texte intégral avec Meilisearch</li>
                    <li>Intégration OAuth (Google, Facebook)</li>
                    <li>Support multilingue (EN, FR)</li>
                    <li>Tableau de bord administrateur avec Filament</li>
                </ul>
            </div>
            <div style="background: #fff3e0; padding: 20px; border-radius: 8px; border-left: 4px solid #ff9800;">
                <h3 style="margin-top: 0; color: #e65100;">🎯 Meilleures Pratiques</h3>
                <ul style="margin: 10px 0; padding-left: 20px; font-size: 15px;">
                    <li>Motifs de conception API RESTful</li>
                    <li>Autorisation appropriée avec Politiques</li>
                    <li>Factories et ensemençage de base de données</li>
                    <li>Suivi et surveillance des erreurs</li>
                    <li>Pipeline de déploiement automatisé</li>
                    <li>Accessibilité (conforme WCAG)</li>
                </ul>
            </div>
        </div>

        <h2 style="font-size: 24px; font-weight: 700; margin-top: 40px; border-bottom: 3px solid #667eea; padding-bottom: 10px;">📚 Documentation</h2>
        <ul style="columns: 2; gap: 30px; font-size: 16px;">
            <li><a href="#introduction" style="color: #667eea; text-decoration: none; font-weight: 500;">👋 Introduction</a></li>
            <li><a href="#installation" style="color: #667eea; text-decoration: none; font-weight: 500;">⚙️ Installation</a></li>
            <li><a href="#configuration" style="color: #667eea; text-decoration: none; font-weight: 500;">🔧 Configuration</a></li>
            <li><a href="#features" style="color: #667eea; text-decoration: none; font-weight: 500;">✨ Fonctionnalités</a></li>
            <li><a href="#database-structure" style="color: #667eea; text-decoration: none; font-weight: 500;">🗄️ Base de Données</a></li>
            <li><a href="#testing" style="color: #667eea; text-decoration: none; font-weight: 500;">🧪 Tests</a></li>
            <li><a href="#deployment" style="color: #667eea; text-decoration: none; font-weight: 500;">🚀 Déploiement</a></li>
            <li><a href="#third-party" style="color: #667eea; text-decoration: none; font-weight: 500;">🔗 Intégrations</a></li>
        </ul>

        <h2 id="introduction" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">👋 Introduction</h2>
        <p style="font-size: 16px; line-height: 1.8;">
            <strong>CarHub</strong> est une application Laravel full-stack prête pour la production démontrant les meilleures pratiques de développement web modernes.
            Construite avec l'évolutivité et la maintenabilité au cœur, la plateforme offre des capacités de recherche avancées, des fonctionnalités en temps réel,
            des tests complets et une surveillance de niveau entreprise. La base de code sert à la fois de marché fonctionnel et de mise en œuvre de référence
            pour les meilleures pratiques Laravel, y compris la conception API, les modèles d'autorisation, l'optimisation des bases de données et l'automatisation du déploiement.
        </p>
        <p style="font-size: 15px; color: #666; margin-top: 15px;">
            <strong>Idéal pour :</strong> Apprendre les motifs Laravel avancés, recruter des développeurs talentueux ou déployer un marché automobile évolutif.
        </p>

        <h2 id="installation" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">⚙️ Démarrage Rapide</h2>
        <pre style="background: #2d2d2d; color: #f8f8f2; padding: 20px; border-radius: 8px; overflow-x: auto; font-size: 14px;">git clone https://github.com/yourusername/laravella-storefront.git
cd laravella-storefront
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve</pre>
        <p style="color: #666; font-size: 15px; margin-top: 15px;">Votre application s'exécutera à <code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px;">http://localhost:8000</code></p>

        <h2 id="configuration" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🔧 Configuration</h2>
        <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
            <p style="margin-top: 0;"><strong>Variables d'Environnement</strong> — Configurez <code>.env</code> :</p>
            <pre style="background: #fff; padding: 12px; border-radius: 4px; overflow-x: auto; font-size: 13px;">APP_NAME=CarHub
APP_ENV=production
DB_CONNECTION=mysql
QUEUE_DRIVER=redis
MEILISEARCH_HOST=http://localhost:7700
SENTRY_LARAVEL_DSN=your-sentry-dsn</pre>
        </div>

        <h2 id="features" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">✨ Vitrine des Fonctionnalités</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
                <h3 style="margin-top: 0; font-size: 16px; font-weight: 600;">🚗 Gestion des Voitures</h3>
                <ul style="margin: 10px 0; font-size: 14px; color: #444;">
                    <li>Opérations CRUD avec autorisation appropriée</li>
                    <li>Gestion des fonctionnalités et des images</li>
                    <li>Opérations en masse avec jobs de file d'attente</li>
                    <li>Optimisation et chargement paresseux des images</li>
                </ul>
            </div>
            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
                <h3 style="margin-top: 0; font-size: 16px; font-weight: 600;">🔐 Authentification</h3>
                <ul style="margin: 10px 0; font-size: 14px; color: #444;">
                    <li>Session + OAuth (Google, Facebook)</li>
                    <li>Flux de vérification d'email</li>
                    <li>Réinitialisation du mot de passe avec validation du jeton</li>
                    <li>Limitation de débit et protection CSRF</li>
                </ul>
            </div>
            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
                <h3 style="margin-top: 0; font-size: 16px; font-weight: 600;">🔍 Recherche Avancée</h3>
                <ul style="margin: 10px 0; font-size: 14px; color: #444;">
                    <li>Recherche en texte intégral avec Meilisearch</li>
                    <li>Filtrage multi-champs (prix, année, lieu)</li>
                    <li>Suggestions de recherche en temps réel</li>
                    <li>Correspondance tolérante aux fautes</li>
                </ul>
            </div>
            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px;">
                <h3 style="margin-top: 0; font-size: 16px; font-weight: 600;">👤 Expérience Utilisateur</h3>
                <ul style="margin: 10px 0; font-size: 14px; color: #444;">
                    <li>Liste de favoris personnalisée</li>
                    <li>Gestion du profil et des préférences</li>
                    <li>Support multilingue (EN/FR)</li>
                    <li>Design responsive (mobile-first)</li>
                </ul>
            </div>
        </div>

        <h2 id="database-structure" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🗄️ Conception de la Base de Données</h2>
        <p style="margin-bottom: 10px;"><strong>Schéma relationnel bien structuré</strong> avec clés étrangères appropriées et index :</p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
            <div><strong>Domaine Principal :</strong>
                <ul style="margin: 5px 0 0 20px; color: #444;">
                    <li>users</li>
                    <li>cars</li>
                    <li>car_features</li>
                    <li>car_images</li>
                    <li>favorite_cars</li>
                </ul>
            </div>
            <div><strong>Taxonomies :</strong>
                <ul style="margin: 5px 0 0 20px; color: #444;">
                    <li>makers</li>
                    <li>models</li>
                    <li>car_types</li>
                    <li>fuel_types</li>
                    <li>states / cities</li>
                </ul>
            </div>
        </div>

        <h2 id="factories-seeders" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🌱 Factories et Seeders
            <p><strong>Factories :</strong></p>
            <ul>
                <li><code>CarFactory</code> : Génère des voitures aléatoires.</li>
                <li><code>CarFeatureFactory</code> : Génère des caractéristiques aléatoires.</li>
                <li><code>CarImageFactory</code> : Génère des images de voitures aléatoires.</li>
                <li><code>UserFactory</code> : Crée des utilisateurs de test.</li>
            </ul>
            <p><strong>Seeders :</strong></p>
            <ul>
                <li><code>DatabaseSeeder</code> : Remplit les données initiales pour les constructeurs, types de voitures,
                    etc.</li>
            </ul>

            <h2 id="routes" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Routes</h2>
            <p><strong>Routes publiques :</strong></p>
            <ul>
                <li><code>/</code> : Page d'accueil.</li>
                <li><code>/car/search</code> : Recherche de voitures.</li>
                <li><code>/signup</code> : Inscription utilisateur.</li>
                <li><code>/login</code> : Connexion utilisateur.</li>
            </ul>
            <p><strong>Routes authentifiées :</strong></p>
            <ul>
                <li><code>/car</code> : Gérer les voitures.</li>
                <li><code>/watchlist</code> : Voir la liste de favoris.</li>
                <li><code>/profile</code> : Gérer le profil.</li>
            </ul>
            <p>Les routes sont définies dans :</p>
            <ul>
                <li><code>web.php</code></li>
                <li><code>auth.php</code></li>
            </ul>

            <h2 id="controllers" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🎮 Contrôleurs et Architecture
                <p><strong>Contrôleurs principaux :</strong></p>
                <ul>
                    <li><strong>CarController :</strong> Gère les opérations CRUD et les caractéristiques des voitures.</li>
                    <li><strong>SignupController :</strong> Gère l'inscription utilisateur.</li>
                    <li><strong>WatchlistController :</strong> Gère l'ajout/retrait de voitures dans la liste de favoris.</li>
                    <li><strong>ProfileController :</strong> Gère la mise à jour du profil et du mot de passe.</li>
                </ul>

                <h2 id="policies" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🔒 Autorisation et Politiques
                    <p><strong>CarPolicy :</strong> Autorise les actions comme la création, la modification et la suppression de
                        voitures.</p>

                    <h2 id="testing" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🧪 Couverture de Test</h2>
                    <p style="font-size: 16px; margin-bottom: 15px;">Le projet inclut <strong>20+ tests fonctionnels</strong> assurant que la fonctionnalité principale est robuste :</p>
                    <div style="background: #f0f7ff; padding: 20px; border-radius: 8px; border-left: 4px solid #2196f3;">
                        <code style="font-family: monospace; font-size: 14px; color: #333;">
                            CarTest • AuthTest • SignupTest • WatchlistTest • ProfileTest • PasswordResetTest • HomeTest • EmailVerifyTest • FavoritesTest • SearchTest
                        </code>
                    </div>
                    <p style="margin-top: 15px; color: #666; font-size: 14px;">Exécuter les tests : <code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px;">php artisan test</code> · Couverture : <code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px;">php artisan test --coverage</code></p>

                    <h2 id="accessibility" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">♿ Accessibilité et SEO</h2>
                    <div style="background: #e8f5e9; padding: 20px; border-radius: 8px; border-left: 4px solid #4caf50;">
                        <p style="margin-top: 0;"><strong>Conforme WCAG 2.1 :</strong></p>
                        <ul style="margin: 10px 0; color: #2e7d32; font-size: 14px;">
                            <li>✓ Structure HTML sémantique</li>
                            <li>✓ Prise en charge de la navigation au clavier</li>
                            <li>✓ Convivialité du lecteur d'écran</li>
                            <li>✓ Labels et rôles ARIA</li>
                            <li>✓ Contraste des couleurs (minimum 4,5:1)</li>
                            <li>✓ Design responsive</li>
                        </ul>
                        <p style="margin-bottom: 0;"><strong>Optimisé pour le SEO :</strong></p>
                        <ul style="margin: 10px 0; color: #2e7d32; font-size: 14px;">
                            <li>✓ Balises dynamiques et URLs canoniques</li>
                            <li>✓ Cartes Open Graph et Twitter</li>
                            <li>✓ Données structurées (Schema.org)</li>
                            <li>✓ Responsive mobile-first</li>
                        </ul>
                    </div>

                    <h2 id="seo" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Fonctionnalités SEO</h2>
                    <ul>
                        <li>Titres de page et meta descriptions dynamiques pour chaque page.</li>
                        <li>URLs canoniques pour éviter le contenu dupliqué.</li>
                        <li>Meta tags Open Graph et Twitter Card pour le partage sur les réseaux sociaux.</li>
                        <li>Design responsive pour le classement SEO mobile.</li>
                        <li>Structure HTML propre et sémantique pour un meilleur indexation.</li>
                    </ul>

                    <h2 id="styling-frontend" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🎨 Frontend et Style
                        <ul>
                            <li><strong>CSS :</strong> Situé dans <code>app.css</code>.</li>
                            <li><strong>JavaScript :</strong> Situé dans <code>app.js</code>.</li>
                        </ul>

                        <h2 id="third-party" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🔗 Intégrations et Surveillance</h2>
                        <div style="background: #f5f5f5; padding: 20px; border-radius: 8px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
                            <div>
                                <strong style="color: #667eea;">Authentification</strong>
                                <ul style="margin: 8px 0 0 20px; color: #444;">
                                    <li>✓ Google OAuth (Socialite)</li>
                                    <li>✓ Facebook OAuth (Socialite)</li>
                                </ul>
                            </div>
                            <div>
                                <strong style="color: #667eea;">Communication</strong>
                                <ul style="margin: 8px 0 0 20px; color: #444;">
                                    <li>✓ Mailtrap (test email)</li>
                                    <li>✓ Vérification email et réinitialisation du mot de passe</li>
                                </ul>
                            </div>
                            <div>
                                <strong style="color: #667eea;">Surveillance et Performance</strong>
                                <ul style="margin: 8px 0 0 20px; color: #444;">
                                    <li>✓ Sentry (suivi des erreurs)</li>
                                    <li>✓ Lighthouse CI (performance)</li>
                                </ul>
                            </div>
                            <div>
                                <strong style="color: #667eea;">Recherche et Temps Réel</strong>
                                <ul style="margin: 8px 0 0 20px; color: #444;">
                                    <li>✓ Meilisearch (recherche en texte intégral)</li>
                                    <li>✓ Laravel Reverb (WebSockets)</li>
                                </ul>
                            </div>
                        </div>
                        <h2 id="deployment" style="font-size: 20px; font-weight: 700; margin-top: 50px; color: #667eea;">🚀 Pipeline CI/CD</h2>
                        <p style="font-size: 16px; line-height: 1.8; margin-bottom: 20px;">
                            Déploiement automatisé via <strong>GitHub Actions</strong> — chaque version déclenche un cycle complet de build, test et déploiement.
                        </p>

                        <div style="background: #fafafa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                            <h3 style="margin-top: 0; font-weight: 700; font-size: 16px;">Pipeline de Flux de Travail</h3>
                            <div style="display: grid; grid-template-columns: auto 1fr; gap: 15px; font-size: 14px;">
                                <div><strong>✓ Checkout</strong></div>
                                <div>Code extrait de la balise de version GitHub</div>
                                <div><strong>✓ Setup</strong></div>
                                <div>PHP 8.2 + Node.js + Composer + npm</div>
                                <div><strong>✓ Install</strong></div>
                                <div>Dépendances installées et mises en cache</div>
                                <div><strong>✓ Build</strong></div>
                                <div>Migrations, génération de clé, compilation d'assets</div>
                                <div><strong>✓ Test</strong></div>
                                <div>Suite de tests complète avant déploiement</div>
                                <div><strong>✓ Deploy</strong></div>
                                <div>Le serveur extrait la dernière version, optimise l'app</div>
                            </div>
                        </div>
                        <p style="color: #666; font-size: 14px;">Configuration : <code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px;">.github/workflows/deploy.yml</code></p>

                        <div style="margin-top: 60px; padding: 30px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border-radius: 12px; border: 1px solid #667eea30;">
                            <h2 style="font-size: 20px; font-weight: 700; margin-top: 0; color: #667eea;">📄 Licence et Contribution</h2>
                            <p style="margin: 10px 0; font-size: 15px; color: #555;">
                                Cette application est un <strong>logiciel open-source</strong> sous licence <strong>MIT</strong>.
                                Nous accueillons les contributions de la communauté. Forkez le dépôt, créez une branche de fonctionnalité et soumettez une demande de pull.
                            </p>
                            <p style="margin: 10px 0; font-size: 15px; color: #555;">
                                <strong>Des questions ?</strong> Consultez le dépôt GitHub ou consultez la documentation détaillée dans le dossier <code>/docs</code>.
                            </p>
                        </div>
    </div>
</x-app>