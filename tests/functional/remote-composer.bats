#!/usr/bin/env bats

#
# remote-composer.bats
#
# Run the remote composer
#

@test "determine why symfony/console is required" {
  run terminus composer $TERMINUS_SITE.dev depends symfony/console
  [ "$status" -eq 0 ]
  [[ "$output" == *"drupal/core"* ]]
  [[ "$output" == *"drush/drush"* ]]
}

@test "look at licenses" {
  run terminus composer $TERMINUS_SITE.dev licenses
  [ "$status" -eq 0 ]
  [[ "$output" == *"GPL-2.0+"* ]]
  [[ "$output" == *"MIT"* ]]
}
