<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Options</title>

</head>
<body>
    <div class="flex--item">
        <!-- Filter Button -->
        <button class="s-btn s-btn__outlined s-btn__sm s-btn__icon ws-nowrap btn" onclick="toggleFilterForm()" role="button" aria-expanded="false">
            <svg aria-hidden="true" class="svg-icon iconFilter" width="18" height="18" viewBox="0 0 18 18">
                <path d="M2 4h14v2H2zm2 4h10v2H4zm8 4H6v2h6z"></path>
            </svg>
            Filter
        </button>
    </div>
    <!-- Filter Form (Initially Hidden) -->
    <div id="filterForm" class="filter-form">
        <h3>Filter Options</h3>
        <form action="process_filter.php" method="GET">
            <!-- Add your filter options here -->
            <div class="filter-option">
                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="all">All</option>
                    <option value="category1">Nearest</option>
                    <option value="category2">Category 2</option>
                    <option value="category3">Category 3</option>
                </select>
            </div>
            <div class="filter-option">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date">
            </div>
            <div class="filter-option">
                <label for="keyword">Keyword:</label>
                <input type="text" name="keyword" id="keyword" placeholder="Enter keyword...">
            </div>
            <input type="submit" class="btn" value="Apply Filters">
        </form>
        <?php include 'templates/headercontent.php'; ?>
    </div>
</body>
</html>
