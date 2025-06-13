<?php
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Movie.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}


$auth = new Auth();
$movie = new Movie();
$message = '';

$auth->requireAdmin();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_movie'])) {
        if ($movie->create($_SESSION['user_id'], $_POST['title'], $_POST['youtube_url'])) {
            $message = 'Movie added successfully!';
        } else {
            $message = 'Failed to add movie';
        }
    } elseif (isset($_POST['update_movie'])) {
        if ($movie->update($_POST['movie_id'], $_POST['title'], $_POST['youtube_url'])) {
            $message = 'Movie updated successfully!';
        } else {
            $message = 'Failed to update movie';
        }
    } elseif (isset($_POST['delete_movie'])) {
        if ($movie->delete($_POST['movie_id'])) {
            $message = 'Movie deleted successfully!';
        } else {
            $message = 'Failed to delete movie';
        }
    }
}

$all_movies = $movie->getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - Manage Videos</title>
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

        .form-container {
            background-color: #222;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        .movie-item {
            background-color: #333;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-danger {
            background-color: #e50914;
            border-color: #e50914;
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

        .nav-link:hover,
        .nav-link.active {
            background-color: #333;
            color: #e50914;
        }

        /* Form container styles */
        .form-container {
            background-color: #222;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        /* Movie item styles */
        .movie-item {
            background-color: #333;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-danger {
            background-color: #e50914;
            border-color: #e50914;
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

        /* Modal styles */
        .modal-content {
            background-color: #222;
            color: white;
        }

        .modal-header {
            border-bottom-color: #444;
        }

        .modal-footer {
            border-top-color: #444;
        }

        /* Responsive styles */
        @media (max-width: 1200px) {
            .movie-item {
                gap: 1rem;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .container-fluid {
                margin-top: 4rem;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .container-fluid {
                padding: 0 1rem;
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
            <a class="nav-link active"><i class="fas fa-video me-2"></i>Manage Video</a>
            <hr>
            <a class="nav-link" href="../pages/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Manage Your Videos</h2>

            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>

            <div class="form-container">
                <h4>Add New Movie/Animation</h4>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">YouTube URL</label>
                                <input type="url" class="form-control" name="youtube_url" placeholder="https://www.youtube.com/watch?v=..." required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="add_movie" class="btn btn-danger">Add Movie</button>
                </form>
            </div>

            <h4>Your Movies</h4>
            <?php if (empty($all_movies)): ?>
                <p class="text-muted">You haven't uploaded any movies yet.</p>
            <?php else: ?>
                <?php foreach ($all_movies as $m): ?>
                    <div class="movie-item">
                        <div>
                            <h5><?= htmlspecialchars($m['title']) ?></h5>
                            <small class="text-muted">Uploaded: <?= date('M d, Y', strtotime($m['created_at'])) ?></small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-light me-2" onclick="editMovie(<?= $m['id'] ?>, '<?= htmlspecialchars($m['title']) ?>', '<?= htmlspecialchars($m['youtube_url']) ?>')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                <input type="hidden" name="movie_id" value="<?= $m['id'] ?>">
                                <button type="submit" name="delete_movie" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Movie</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="edit_movie_id" name="movie_id">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">YouTube URL</label>
                            <input type="url" class="form-control" id="edit_youtube_url" name="youtube_url" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_movie" class="btn btn-danger">Update</button>
                    </div>
                </form>
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

        function editMovie(id, title, youtube_url) {
            document.getElementById('edit_movie_id').value = id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_youtube_url').value = youtube_url;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
</body>

</html>