# Get started!

# Working in branches

# Configuration management

When working in teams on configuration the order in which you import and export configuration is very important. A typical setup is like this, where the `master` branch is the main branch in this example and `my_new_branch` as the new branch name

1. Before you start working on your task make sure you pull all the changes from `develop`
2. Import the configuration with `drush cim`. Don't use the `-y` flag, you'll want the control here.
3. Branch off to a new branch with `git checkout -b my_new_branch`
4. Do all your work / configuration in Drupal
5. This is important: export **your** configuration with `drush cex`, again no `-y` flag
6. Examine the changes, see if nothing is out of the ordinary
7. Commit your (config) changes and push them to the branch (`git commit -m "[message]"`, `git push`)
8. Now pull/merge the master branch into your branch `git pull origin master`. Git will now try to merge the configuration from the remote with your configuration. Conflicts could occur when working on the same stuff, but is easily fixed.
9. Commit and push the merge to your branch with `git push`
10. Import the pulled (if any) configuration from `develop`. Your site is now up to date with the latest configuration.
11. When the branch is merged into master you can check master out locally and start from step 3 again.
