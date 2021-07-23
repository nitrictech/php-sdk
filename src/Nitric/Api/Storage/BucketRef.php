<?php

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

namespace Nitric\Api\Storage;

use Nitric\Api\Storage;

/**
 * Class BucketRef represents a reference to a bucket from a storage service. The bucket may or may not exist.
 * @package Nitric\Api
 */
class BucketRef
{

    protected Storage $storage;
    protected string $name;

    public function __construct(Storage $storage, string $name)
    {
        $this->storage = $storage;
        $this->name = $name;
    }

    /**
     * Return a reference to a file in this bucket.
     *
     * @param string $id the unique id of the file, often a path e.g. "image/picture.jpg".
     * @return FileRef
     */
    public function file(string $id)
    {
        return new FileRef($this->storage, $this, $id);
    }

    /**
     * Return the bucket's name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
