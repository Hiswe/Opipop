JS_GEN_LIST := $(shell find js -path . -prune -o -type f -name "*.js" -print | grep -v "^js/_prod/" | grep -v "^js/_gen/" | xargs | sed "s/js\//js\/_gen\//g")

all: $(JS_GEN_LIST) jspack css

js/_gen/%: js/%
	@echo '... compressing $@'
	java -jar exec/yuicompressor-2.4.2.jar $(shell echo "$@" | sed "s/js\/_gen\//js\//g") -o $@ --type js --charset utf-8

jspack:
	ruby exec/make_jspacks.rb

css:
	compass compile css

