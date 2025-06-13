<?php

require_once __DIR__ . '/../classes/Movie.php';
require_once __DIR__ . '/../classes/Auth.php';

// Initialize Auth and Movie classes
$auth = new Auth();
$movie = new Movie();

// Require login to access catalog
$auth->requireLogin();

// Get all movies
$movies = $movie->getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #141414;
            color: white;
            font-family: 'Arial', sans-serif;
        }

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

        .movie-card {
            background-color: #222;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            margin-bottom: 2rem;
            cursor: pointer;
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
            object-fit: cover;
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

        .search-bar {
            background-color: #333;
            border: none;
            color: white;
            border-radius: 25px;
            padding: 0.5rem 1rem;
            margin-bottom: 2rem;
        }

        .search-bar:focus {
            background-color: #444;
            color: white;
            box-shadow: none;
            border: 1px solid #e50914;
        }

        body {
            background-color: #141414;
            color: white;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Sidebar styles */
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

        /* Update sidebar styles */
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
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        

        /* Search bar styles */
        .search-bar {
            background-color: #333;
            border: none;
            color: white;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 400px;
        }

        .search-bar:focus {
            background-color: #444;
            color: white;
            box-shadow: none;
            border: 1px solid #e50914;
            outline: none;
        }

        /* Movie card styles */
        .movie-card {
            height: 100%;
            background-color: #222;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            margin-bottom: 1rem;
            cursor: pointer;
        }

        .movie-card:hover {
            transform: scale(1.05);
        }

        .movie-info {
            padding: 1rem;
        }

        /* Menu toggle for mobile */
        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
            position: fixed;
            right: 1rem;
            top: 1rem;
            z-index: 1001;
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 0.5rem;
            border-radius: 5px;
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

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .container-fluid {
                margin-top: 4rem;
            }

            .menu-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .nav.flex-column {
                display: block !important;
            }

            .nav-link {
                padding: 0.75rem 1rem;
                display: block;
                margin: 0.5rem 0;
            }

            .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .movie-card {
                margin-bottom: 1.5rem;
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
            <a class="nav-link" href="homepage.php"><i class="fas fa-home me-2"></i>Home</a>
            <a class="nav-link active" href="catalog.php"><i class="fas fa-th-large me-2"></i>Catalog</a>
            <hr>
            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2>Movie & Animation Catalog</h2>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control search-bar" id="searchInput" placeholder="Search movies...">
                </div>
            </div>

            <div class="row" id="movieGrid">
                <?php foreach ($movies as $m): ?>
                    <?php
                    $youtube_id = $movie->getYouTubeId($m['youtube_url']);
                    $thumbnail = $youtube_id ? "https://img.youtube.com/vi/{$youtube_id}/hqdefault.jpg" : 'https://via.placeholder.com/300x200';
                    ?>
                    <div class="col-md-3 col-sm-6 movie-item" data-title="<?= strtolower(htmlspecialchars($m['title'])) ?>" data-author="<?= strtolower(htmlspecialchars($m['username'])) ?>">
                        <div class="movie-card" data-youtube-id="<?= $youtube_id ?>" onclick="window.location.href='movie_detail.php?id=<?= $m['id'] ?>'">
                            <div class="media-container">
                                <img src="<?= $thumbnail ?>" class="movie-thumbnail" alt="<?= htmlspecialchars($m['title']) ?>">
                                <div class="video-preview"></div>
                            </div>
                            <div class="movie-info">
                                <div class="movie-title"><?= htmlspecialchars($m['title']) ?></div>
                                <div class="movie-author">by <?= htmlspecialchars($m['username']) ?></div>
                                <small class="text-muted">Uploaded: <?= date('M d, Y', strtotime($m['created_at'])) ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($movies)): ?>
                <div class="text-center text-muted">
                    <i class="fas fa-film fa-3x mb-3"></i>
                    <p>No movies available yet. Be the first to upload!</p>
                </div>
            <?php endif; ?>
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
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const movieItems = document.querySelectorAll('.movie-item');

            movieItems.forEach(item => {
                const title = item.getAttribute('data-title');
                const author = item.getAttribute('data-author');

                if (title.includes(searchTerm) || author.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
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