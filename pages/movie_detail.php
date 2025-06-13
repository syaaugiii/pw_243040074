<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../classes/Movie.php';
$movie_obj = new Movie();

if (!isset($_GET['id'])) {
    header('Location: catalog.php');
    exit;
}

$movie = $movie_obj->getById($_GET['id']);
if (!$movie) {
    header('Location: catalog.php');
    exit;
}

$youtube_id = $movie_obj->getYouTubeId($movie['youtube_url']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($movie['title']) ?> - MovieFlix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #141414;
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .sidebar {
            background-color: #000;
            min-height: 100vh;
            padding: 1rem;
            position: fixed;
            width: 200px;
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

        .nav-link:hover {
            background-color: #333;
            color: #e50914;
        }

        .video-container {
            background-color: #222;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .video-iframe {
            width: 100%;
            height: 500px;
            border-radius: 10px;
        }

        .movie-info {
            background-color: #333;
            border-radius: 10px;
            padding: 2rem;
        }

        .back-btn {
            background-color: #666;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .back-btn:hover {
            background-color: #777;
            color: white;
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
            transition: all 0.3s ease;
            z-index: 1000;
        }

        /* Main content styles */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        /* Video container styles */
        .video-container {
            background-color: #222;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .video-iframe {
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: 10px;
            height: auto;
            min-height: 300px;
        }

        /* Movie info styles */
        .movie-info {
            background-color: #333;
            border-radius: 10px;
            padding: 2rem;
        }

        /* Navigation styles */
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
            background-color: rgba(0, 0, 0, 0.5);
            padding: 0.5rem;
            border-radius: 5px;
        }

        /* Responsive Media Queries */
        @media (max-width: 1200px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 992px) {
            .video-container {
                padding: 1rem;
            }

            .movie-info {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 100%;
                max-width: 300px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .video-container {
                padding: 1rem;
            }

            .movie-info {
                padding: 1rem;
            }

            .video-iframe {
                min-height: 200px;
            }

            .col-md-4.text-end {
                text-align: left !important;
                margin-top: 1rem;
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 1.5rem;
            }

            h3 {
                font-size: 1.2rem;
            }

            .video-iframe {
                min-height: 180px;
            }
        }
    </style>
</head>

<body>
    <div class="menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    <div class="sidebar">
        <div class="brand">MovieFlix</div>
        <nav class="nav flex-column">
            <a class="nav-link" href="homepage.php"><i class="fas fa-home me-2"></i>Home</a>
            <a class="nav-link" href="catalog.php"><i class="fas fa-th-large me-2"></i>Catalog</a>
            <hr>
            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <a href="catalog.php" class="back-btn">
                <i class="fas fa-arrow-left me-2"></i>Back to Catalog
            </a>

            <div class="video-container">
                <h1 class="mb-4"><?= htmlspecialchars($movie['title']) ?></h1>

                <?php if ($youtube_id): ?>
                    <iframe class="video-iframe"
                        src="https://www.youtube.com/embed/<?= $youtube_id ?>"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Invalid YouTube URL. <a href="<?= htmlspecialchars($movie['youtube_url']) ?>" target="_blank" class="text-white">View original link</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="movie-info">
                <div class="row">
                    <div class="col-md-8">
                        <h3>Movie Details</h3>
                        <p><strong>Title:</strong> <?= htmlspecialchars($movie['title']) ?></p>
                        <p><strong>Uploaded by:</strong> <?= htmlspecialchars($movie['username']) ?></p>
                        <p><strong>Upload Date:</strong> <?= date('F j, Y', strtotime($movie['created_at'])) ?></p>
                        <?php if ($movie['updated_at'] != $movie['created_at']): ?>
                            <p><strong>Last Updated:</strong> <?= date('F j, Y', strtotime($movie['updated_at'])) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Menu toggle functionality
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.sidebar') && !e.target.closest('.menu-toggle')) {
                document.querySelector('.sidebar').classList.remove('show');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.querySelector('.sidebar').classList.remove('show');
            }
        });
    </script>
</body>

</html>