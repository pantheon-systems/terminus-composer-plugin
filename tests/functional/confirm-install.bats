#!/usr/bin/env bats

#
# confirm-install.bats
#
# Ensure that Terminus and the Composer plugin have been installed correctly
#

@test "confirm terminus version" {
  terminus --version
}

@test "get help on remote:composer command" {
  run terminus help remote:composer
  [[ $output == *"composer_command"* ]]
  [ "$status" -eq 0 ]
}
