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
class Access {
  public function accessSecret() {
    // [START snippet]
    $secrets = new Secrets();

    // Access the secret value at a specific version
    $secretVersion = "7F5F86D0-D97F-487F-A5A0-11BAAD00F777";
    $secret = $secrets->secret("database.password")->version($secretVersion);
    // [END snippet]
  }
}
?>