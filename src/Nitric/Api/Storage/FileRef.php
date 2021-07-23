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

use Exception;
use Nitric\Api\Storage;
use Nitric\Proto\Storage\V1\StorageDeleteRequest;
use Nitric\Proto\Storage\V1\StorageReadRequest;
use Nitric\Proto\Storage\V1\StorageReadResponse;
use Nitric\Proto\Storage\V1\StorageWriteRequest;
use Nitric\ProtoUtils\Utils;

/**
 * Class FileRef references a file in a bucket from a storage service. The file may or may not actually exist.
 * @package Nitric\Api
 */
class FileRef
{
    protected Storage $storage;
    protected BucketRef $bucket;
    protected string $key;

    /**
     * FileRef constructor.
     *
     * @param Storage $storage nested reference to the storage client.
     * @param BucketRef $bucket the ref of the bucket containing this file.
     * @param string $key the unique id of the file this ref points at.
     */
    public function __construct(Storage $storage, BucketRef $bucket, string $key)
    {
        $this->storage = $storage;
        $this->bucket = $bucket;
        $this->key = $key;
    }

    /**
     * Write contents to the file referred to by this reference, if it doesn't exist it will be created.
     *
     * @param string $bytes byte string containing the file contents to store.
     * @throws Exception
     */
    public function write(string $bytes)
    {
        $request = new StorageWriteRequest();
        $request->setBucketName($this->bucket->getName());
        $request->setKey($this->key);
        $request->setBody($bytes);

        [, $status] = $this->storage->_baseStorageClient->Write($request)->wait();
        Utils::okOrThrow($status);
    }

    /**
     * Read and return the contents of the file referred to by this reference, if it exists.
     *
     * @return string body data as a byte string.
     * @throws Exception
     */
    public function read(): string
    {
        $request = new StorageReadRequest();
        $request->setBucketName($this->bucket->getName());
        $request->setKey($this->key);

        [$response, $status] = $this->storage->_baseStorageClient->Read($request)->wait();
        Utils::okOrThrow($status);
        $response = (fn($r): StorageReadResponse => $r)($response);

        return $response->getBody();
    }

    /**
     * Delete the file referred to by this reference, if it exists.
     */
    public function delete()
    {
        $request = new StorageDeleteRequest();
        $request->setBucketName($this->bucket->getName());
        $request->setKey($this->key);

        [$response, $status] = $this->storage->_baseStorageClient->Delete($request)->wait();
        Utils::okOrThrow($status);
    }

    /**
     * Get the file's key.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
