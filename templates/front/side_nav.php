<div class="col-md-3">
    <p class="lead">Pet Supply Store</p>
    <div class="list-group">
        <?php
        // Fetch categories with their subcategories
        $query = query("SELECT * FROM categories");
        $categories = $query->fetch_all(MYSQLI_ASSOC); 
        
        // Organize categories and subcategories
        $cats = []; 
        foreach ($categories as $category) {
            if ($category['parent'] == 0) {
                $cats[$category['cat_id']] = $category; 
                $cats[$category['cat_id']]['subcategories'] = []; 
            } else {
                $cats[$category['parent']]['subcategories'][] = $category;
            }
        }
        
        // Loop through categories
        foreach ($cats as $category) {
            echo "<a href='#' class='list-group-item category-link' onclick='toggleSubcategories(this)'>{$category['cat_title']}</a>";
            
            // Check if subcategories exist
            if (!empty($category['subcategories'])) {
                echo "<div class='list-group subcategory-list' style='display: none;'>";
                
                // Loop through subcategories
                foreach ($category['subcategories'] as $subcategory) {
                    echo "<a href='category.php?id={$subcategory['cat_id']}' class='list-group-item subcategory-link'>{$subcategory['cat_title']}</a>";
                }
                
                echo "</div>"; // Close list-group for subcategories
            }
        }
        ?>
    </div>
</div>

<script>
    function toggleSubcategories(categoryLink) {
        var subcategoryList = categoryLink.nextElementSibling;
        if (subcategoryList.style.display === "none") {
            subcategoryList.style.display = "block";
        } else {
            subcategoryList.style.display = "none";
        }
    }
</script>
