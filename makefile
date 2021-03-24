# Generate interfaces
generate-proto:
	@echo Generating Proto Sources
	@rm -rf ./interfaces/
	@mkdir -p ./interfaces/
	@protoc --php_out=./interfaces/ \
	 --grpc_out=./interfaces/ \
	 --plugin=protoc-gen-grpc=/Users/jcusch/Code/grpc/cmake/build/grpc_php_plugin \
	 -I ./contracts/proto/ ./contracts/proto/**/**/*.proto