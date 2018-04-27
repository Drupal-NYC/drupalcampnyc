<?php

/**
 * @file
 * Pantheon hooks.
 */

// Maintenance on.
echo "Switch to maintenance mode...\n";
passthru('drush sset system.maintenance_mode 1 -y');
echo "In maintenance mode.\n";
// Clear cache.
echo "Clear all cache bins\n";
passthru('drush cr');
echo "Cache clear complete.\n";
// Update database.
echo "Apply database updates\n";
passthru('drush updb -y');
echo "Database updates complete.\n";
// Config Import.
echo "Import configuration\n";
passthru('drush cim sync -y');
echo "Configuration import complete.\n";
// Clear cache.
echo "Clear all cache bins\n";
passthru('drush cr');
echo "Cache clear complete.\n";
// Maintenance off.
echo "Come out of maintenance mode\n";
passthru('drush sset system.maintenance_mode 0 -y');
echo "All deployment tasks are complete.\n";
