<?php 
function display_error_bucket($error_bucket)
{
    echo '<div class="pt-4 alert alert-warning" role="alert">';
    echo '<p>The following errors were detected:</p>';
    echo '<ul>';
    foreach ($error_bucket as $text) {
        echo '<li>' . $text . '</li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '<p>All of these fields are required. Please fill them in.</p>';
}
