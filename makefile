# Generate interfaces
generate-proto:
	@echo Generating Proto Sources
	@rm -rf ./interfaces/
	@mkdir -p ./interfaces/
	@protoc --php_out=./interfaces/ \
	 --grpc_out=./interfaces/ \
	 --plugin=protoc-gen-grpc=/Users/jcusch/Code/grpc/cmake/build/grpc_php_plugin \
	 -I ./contracts/proto/ ./contracts/proto/**/**/*.proto

tests:
	@echo Running Tests
	@XDEBUG_MODE=coverage ./vendor/phpunit/phpunit/phpunit --coverage-html ./coverage.html ./test/ --cache-result-file=./.phpunit.result.cache