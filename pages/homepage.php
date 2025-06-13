<?php
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Movie.php';

// Initialize Auth and Movie classes
$auth = new Auth();
$movie = new Movie();

// Require login to access homepage
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Get the first movie for hero background
$firstMovie = null;

$movies = $movie->getAll();
if (!empty($movies)) {
    $firstMovie = $movies[0];
    $youtube_id = $movie->getYouTubeId($firstMovie['youtube_url']);
}

$movies = $movie->getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .main-content {
            margin-left: 200px;
            padding: 2rem;
        }

        .brand {
            color: #e50914;
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .nav-link {
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 5px;
            margin-bottom: 0.5rem;
            transition: all 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #333;
            color: #e50914;
        }

        .nav-link:hover {
            background-color: #333;
            color: #e50914;
        }

        .movie-card {
            background-color: #222;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            margin-bottom: 2rem;
        }

        .movie-card:hover {
            transform: scale(1.05);
        }

        .media-container {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .movie-thumbnail {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 0.3s;
        }

        .video-preview {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .movie-card:hover .movie-thumbnail {
            opacity: 0;
        }

        .movie-card:hover .video-preview {
            opacity: 1;
        }

        .movie-info {
            padding: 1rem;
        }

        .movie-title {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .movie-author {
            color: #999;
            font-size: 0.9rem;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        .hero-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-section {
            position: relative;
            height: 400px;
            display: flex;
            align-items: center;
            margin-bottom: 3rem;
            border-radius: 10px;
            overflow: hidden;
            z-index: 2;
            color: white;
            padding: 2rem;
        }

        .featured-movie {
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid #e50914;
        }

        .featured-label {
            text-transform: uppercase;
            font-size: 0.9rem;
            color: #e50914;
            margin-bottom: 0.5rem;
            display: block;
            font-weight: bold;
        }

        .featured-title {
            font-size: 2rem;
            margin: 0.5rem 0;
        }

        .featured-author {
            font-size: 1rem;
            opacity: 0.8;
            margin: 0;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        body {
            background-color: #141414;
            color: white;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Sidebar styles */
        .sidebar {
            background-color: #000;
            min-height: 100vh;
            padding: 1rem;
            position: fixed;
            width: 250px;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        /* Main content styles */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            transition: all 0.3s ease;
        }


        .hero-content h1 {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: bold;
        }

        /* Movie card styles */
        .movie-card {
            height: 100%;
            background-color: #222;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            margin-bottom: 1rem;
        }

        /* Responsive Media Queries */
        @media (max-width: 1200px) {
            .col-md-3 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }

            .col-md-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        .movie-info {
            padding: 1rem;
        }

        .container-fluid {
            padding-right: 15px;
            padding-left: 15px;
        }

        /* Navigation improvements */
        .nav-link {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Add hamburger menu for mobile */
        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
            position: absolute;
            right: 1rem;
            top: 1rem;
            z-index: 1001;
        }

        @media (max-width: 768px) {

            .hero-section {
                margin-top: 4rem;
                height: 400px;
            }

            .featured-title {
                font-size: 1.5rem;
            }

            .featured-author {
                font-size: 1rem;
            }

            .hero-content h1 {
                font-size: 1.3rem;
            }

            .hero-content p {
                font-size: 0.8rem;
            }

            .featured-label {
                font-size: 0.7rem;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .nav.flex-column {
                display: block;
            }

            .nav-link {
                padding: 0.75rem 1rem;
                display: block;
                margin: 0.5rem 0;
            }

            /* Add overlay when sidebar is shown */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .col-md-3,
            .col-sm-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .movie-card {
                margin-bottom: 1.5rem;
            }

            .media-container {
                height: 250px;
                /* Increased height for better mobile viewing */
            }

            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }

            .row {
                margin-left: -10px;
                margin-right: -10px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar-overlay"></div>
    <div class="menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    <div class="sidebar">
        <div class="brand">MovieFlix</div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="homepage.php"><i class="fas fa-home me-2"></i>Home</a>
            <a class="nav-link" href="catalog.php"><i class="fas fa-th-large me-2"></i>Catalog</a>
            <hr>
            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="hero-section">
            <div class="video-background">
                <?php if (isset($youtube_id)): ?>
                    <iframe
                        class="hero-video"
                        src="https://www.youtube.com/embed/<?= $youtube_id ?>?autoplay=1&mute=1&controls=0&loop=1&playlist=<?= $youtube_id ?>"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                <?php endif; ?>
            </div>
            <div class="hero-overlay"></div>
            <div class="container position-relative">
                <div class="hero-content">
                    <h1 class="mb-3">Welcome Back, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
                    <p class="hero-subtitle"></p>
                    <?php if (!empty($firstMovie)): ?>
                        <div class="featured-movie">
                            <span class="featured-label">Now Playing:</span>
                            <h2 class="featured-title"><?= htmlspecialchars($firstMovie['title']) ?></h2>
                            <p class="featured-author">By <?= htmlspecialchars($firstMovie['username']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <h2 class="mb-4">Latest Movies & Animations</h2>
            <div class="row">
                <?php foreach ($movies as $m): ?>
                    <?php
                    $youtube_id = $movie->getYouTubeId($m['youtube_url']);
                    $thumbnail = $youtube_id ? "https://img.youtube.com/vi/{$youtube_id}/hqdefault.jpg" : 'https://via.placeholder.com/300x200';
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="movie-card" data-youtube-id="<?= $youtube_id ?>" onclick="window.location.href='movie_detail.php?id=<?= $m['id'] ?>'">
                            <div class="media-container">
                                <img src="<?= $thumbnail ?>" class="movie-thumbnail" alt="<?= htmlspecialchars($m['title']) ?>">
                                <div class="video-preview"></div>
                            </div>
                            <div class="movie-info">
                                <div class="movie-title"><?= htmlspecialchars($m['title']) ?></div>
                                <div class="movie-author">by <?= htmlspecialchars($m['username']) ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');

        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        // Close sidebar when clicking overlay
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.sidebar') &&
                !e.target.closest('.menu-toggle')) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });
        document.querySelectorAll('.movie-card').forEach(card => {
            const videoPreview = card.querySelector('.video-preview');
            const youtubeId = card.dataset.youtubeId;

            card.addEventListener('mouseenter', () => {
                if (youtubeId) {
                    videoPreview.innerHTML = `
                <iframe 
                    width="100%" 
                    height="100%" 
                    src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&mute=1&controls=0&loop=1&playlist=${youtubeId}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen
                ></iframe>
            `;
                }
            });

            card.addEventListener('mouseleave', () => {
                videoPreview.innerHTML = '';
            });
        });
    </script>
</body>

</html>