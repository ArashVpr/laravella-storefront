<x-app title="Documentation">
    <div
        style="max-width: 800px; margin: 40px auto; padding: 20px; font-family: sans-serif; line-height: 1.6; color: #333;">
        <h1 style="font-size: 32px; font-weight: bold; margin-bottom: 20px;">Documentation pour car-hub.xyz</h1>

        <h2 style="font-size: 24px; font-weight: bold; margin-top: 30px;">Table des matières</h2>
        <ul>
            <li><a href="#introduction">Introduction</a></li>
            <li><a href="#installation">Installation</a></li>
            <li><a href="#configuration">Configuration</a></li>
            <li><a href="#features">Fonctionnalités</a></li>
            <li><a href="#database-structure">Structure de la base de données</a></li>
            <li><a href="#factories-seeders">Factories et Seeders</a></li>
            <li><a href="#routes">Routes</a></li>
            <li><a href="#controllers">Contrôleurs</a></li>
            <li><a href="#policies">Politiques</a></li>
            <li><a href="#testing">Tests</a></li>
            <li><a href="#accessibility">Accessibilité</a></li>
            <li><a href="#seo">SEO</a></li>
            <li><a href="#styling-frontend">Style et Frontend</a></li>
            <li><a href="#third-party">Intégrations tierces</a></li>
            <li><a href="#deployment">Déploiement (avec GitHub Actions)</a></li>
            <li><a href="#license">Licence</a></li>
        </ul>

        <h2 id="introduction" style="font-size: 20px; font-weight: bold; margin-top: 40px;">Introduction</h2>
        <p>car-hub.xyz est une application web basée sur Laravel conçue pour gérer les voitures, leurs caractéristiques
            et les interactions utilisateur telles que les listes de favoris et l'authentification. Elle utilise les
            fonctionnalités intégrées de Laravel comme Eloquent ORM, les templates Blade et Sanctum pour
            l'authentification API.</p>

        <h2 id="installation" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Installation</h2>
        <ul>
            <li>Cloner le dépôt</li>
            <li>Installer les dépendances :
                <ul>
                    <li>Exécuter <code>composer install</code></li>
                    <li>Exécuter <code>npm install</code></li>
                </ul>
            </li>
            <li>Copier <code>.env.example</code> vers <code>.env</code></li>
            <li>Générer la clé d'application : <code>php artisan key:generate</code></li>
            <li>Configurer la base de données dans <code>.env</code> et lancer les migrations : <code>php artisan
                    migrate --seed</code></li>
            <li>Compiler les assets frontend : <code>npm run dev</code></li>
            <li>Démarrer le serveur de développement : <code>php artisan serve</code></li>
        </ul>

        <h2 id="configuration" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Configuration</h2>
        <ul>
            <li><strong>Variables d'environnement :</strong> Configurez le fichier <code>.env</code> pour la base de
                données, le mail et les services tiers.</li>
            <li><strong>Configuration des files d'attente :</strong> Mettez à jour <code>queue.php</code> pour les
                drivers comme Redis ou la base de données.</li>
            <li><strong>Authentification :</strong> Utilise la connexion basée sur la session.</li>
        </ul>

        <h2 id="features" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Fonctionnalités</h2>
        <ul>
            <li><strong>Gestion des voitures :</strong>
                <ul>
                    <li>Ajouter, modifier, supprimer et voir les voitures.</li>
                    <li>Gérer les caractéristiques et les images des voitures.</li>
                </ul>
            </li>
            <li><strong>Authentification utilisateur :</strong>
                <ul>
                    <li>Connexion, inscription et réinitialisation du mot de passe.</li>
                    <li>Connexion OAuth via Google et Facebook.</li>
                </ul>
            </li>
            <li><strong>Liste de favoris :</strong> Ajouter ou retirer des voitures de la liste de favoris de
                l'utilisateur.</li>
            <li><strong>Gestion du profil :</strong> Mettre à jour le profil utilisateur et le mot de passe.</li>
            <li><strong>Recherche et filtres :</strong> Rechercher des voitures par marque, modèle, ville et autres
                attributs.</li>
            <li><strong>Panneau d'administration :</strong> Gérer les utilisateurs et les voitures via Filament Admin
                Panel.</li>
        </ul>

        <h2 id="database-structure" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Structure de la base
            de données</h2>
        <p>Tables métier :</p>
        <ul>
            <li><code>users</code> : Informations utilisateur.</li>
            <li><code>cars</code> : Détails des voitures.</li>
            <li><code>car_features</code> : Caractéristiques de chaque voiture.</li>
            <li><code>car_images</code> : Images des voitures.</li>
            <li><code>favorite_cars</code> : Liste de favoris utilisateur.</li>
            <li><code>makers</code> : Constructeurs automobiles.</li>
            <li><code>models</code> : Modèles de voitures, liés aux constructeurs.</li>
            <li><code>car_types</code> : Types de voitures (ex : berline, SUV).</li>
            <li><code>fuel_types</code> : Types de carburant (ex : essence, diesel).</li>
            <li><code>cities</code> : Villes, liées aux états.</li>
            <li><code>states</code> : États.</li>
        </ul>

        <h2 id="factories-seeders" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Factories et Seeders
        </h2>
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

        <h2 id="controllers" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Contrôleurs</h2>
        <p><strong>Contrôleurs principaux :</strong></p>
        <ul>
            <li><strong>CarController :</strong> Gère les opérations CRUD et les caractéristiques des voitures.</li>
            <li><strong>SignupController :</strong> Gère l'inscription utilisateur.</li>
            <li><strong>WatchlistController :</strong> Gère l'ajout/retrait de voitures dans la liste de favoris.</li>
            <li><strong>ProfileController :</strong> Gère la mise à jour du profil et du mot de passe.</li>
        </ul>

        <h2 id="policies" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Politiques</h2>
        <p><strong>CarPolicy :</strong> Autorise les actions comme la création, la modification et la suppression de
            voitures.</p>

        <h2 id="testing" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Tests</h2>
        <p><strong>Tests fonctionnels :</strong></p>
        <ul>
            <li><code>CarTest</code> : Fonctionnalités liées aux voitures.</li>
            <li><code>AuthTest</code> : Authentification.</li>
            <li><code>SignupTest</code> : Inscription utilisateur.</li>
            <li><code>WatchlistTest</code> : Accès et actions sur la liste de favoris.</li>
            <li><code>ProfileTest</code> : Accès à la page profil.</li>
            <li><code>PasswordResetTest</code> : Réinitialisation du mot de passe.</li>
            <li><code>HomeTest</code> : Affichage des voitures sur la page d'accueil.</li>
        </ul>
        <p>Exécuter les tests avec : <code>php artisan test</code></p>

        <h2 id="accessibility" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Accessibilité</h2>
        <ul>
            <li>HTML sémantique pour une meilleure prise en charge des lecteurs d'écran.</li>
            <li>Contraste des couleurs et tailles de police pour la lisibilité.</li>
            <li>Navigation accessible au clavier.</li>
            <li>Formulaires avec labels et messages d'erreur appropriés.</li>
            <li>Design responsive pour tous les appareils.</li>
        </ul>

        <h2 id="seo" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Fonctionnalités SEO</h2>
        <ul>
            <li>Titres de page et meta descriptions dynamiques pour chaque page.</li>
            <li>URLs canoniques pour éviter le contenu dupliqué.</li>
            <li>Meta tags Open Graph et Twitter Card pour le partage sur les réseaux sociaux.</li>
            <li>Design responsive pour le classement SEO mobile.</li>
            <li>Structure HTML propre et sémantique pour un meilleur indexation.</li>
        </ul>

        <h2 id="styling-frontend" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Style et Frontend</h2>
        <ul>
            <li><strong>CSS :</strong> Situé dans <code>app.css</code>.</li>
            <li><strong>JavaScript :</strong> Situé dans <code>app.js</code>.</li>
        </ul>

        <h2 id="third-party" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Intégrations tierces</h2>
        <ul>
            <li><strong>Socialite :</strong> Connexion OAuth Google et Facebook. Configuré dans
                <code>services.php</code>.
            </li>
            <li><strong>Mailtrap :</strong> Utilisé pour la vérification des emails et les tests d'envoi (<a
                    href="https://mailtrap.io/" target="_blank">mailtrap.io</a>).</li>
        </ul>
        <h2 id="deployment" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Déploiement (avec GitHub
            Actions)</h2>
        <p>L'application utilise GitHub Actions pour l'intégration et le déploiement continus (CI/CD). Le processus de
            déploiement est automatisé et déclenché lors de la création d'une nouvelle release.</p>

        <h3 style="font-weight: bold;">Workflow GitHub Actions</h3>
        <p>Le workflow de déploiement est défini dans <code>deploy.yml</code>.</p>

        <h3 style="font-weight: bold;">Comment ça marche</h3>
        <ul>
            <li><strong>Déclencheur :</strong> Le workflow est déclenché lors de la création d'une nouvelle release sur
                le dépôt GitHub.</li>
            <li><strong>Étapes de build :</strong>
                <ul>
                    <li>Le code est récupéré.</li>
                    <li>Les environnements PHP et Node.js sont configurés.</li>
                    <li>Les dépendances sont installées avec Composer et npm.</li>
                    <li>Les tâches Laravel comme la génération de la clé, la création du lien de stockage et l'exécution
                        des migrations sont réalisées.</li>
                    <li>Les assets frontend sont compilés.</li>
                    <li>Les tests sont exécutés pour vérifier le bon fonctionnement de l'application.</li>
                </ul>
            </li>
            <li><strong>Déploiement :</strong> L'application est déployée sur le serveur via
                <code>appleboy/ssh-action</code>. Le serveur récupère le dernier tag de release, installe les
                dépendances, compile les assets et optimise l'application Laravel.
            </li>
        </ul>

        <h2 id="license" style="font-size: 20px; font-weight: bold; margin-top: 30px;">Licence</h2>
        <p>Cette application est un logiciel open source sous licence MIT.</p>
    </div>
</x-app>
