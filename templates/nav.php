<nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="margin-bottom: 20px;">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Study Buddy</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?php if($page == "Groupchats") {echo "active";} ?>"  href="/"><i class="bi bi-chat-left-dots"></i> Groupchats</a>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page == "Messages") {echo "active";} ?>" href="messages.php"><i class="bi bi-envelope"></i> Inbox</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="controllers/auth/logout.php" style="color: #DC143C"><i class="bi bi-box-arrow-left"></i> LOGOUT</a>
        </li>
      </ul>
      <form id="search-bar" class="d-flex">
        <input class="form-control me-sm-2" type="text" id="searchBarUsername" placeholder="Search for a student">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>