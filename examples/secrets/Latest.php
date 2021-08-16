<?php
namespace Examples\Secrets;
/**
 * Copyright 2021 Nitric Technologies Pty Ltd.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// [START import]
use Nitric\Api\Secrets;
// [END import]
class Latest {
  public function latestSecret() {
    // [START snippet]
    $secrets = new Secrets();

    // Access the secret value at a specific version
    $secret = $secrets->secret("database.password")->latest();
    // [END snippet]
  }
}
?>