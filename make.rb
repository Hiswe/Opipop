require 'conf/jspack.rb'

# CLEAN THE JS/PROD FOLDER
puts '>> cleaning folder'
dir = Dir.new 'js/prod'
dir.each {|file|
  File.delete 'js/prod/' + file if (file != '.' and file != '..')
}

# LOOP ON EACH PACK
JSPack.each {|name, files|
  puts '>> building pack: ' + name

  # COMPRESS EACH PACK'S FILES
  files.each{|file|
    puts '   ... compressing ' + file
    exit unless Kernel.system 'java -jar bin/yuicompressor-2.4.2.jar js/' + file + ' -o js/prod/' + file.sub(/^(?:[^\/]*\/)?(.*)$/, '\1') + ' --type js --charset utf-8'
  }

  # PACK ALL PACK'S FILES IN ONE
  puts '   ... packing'
  data = ''
  files.each{|file|
    f = File.open 'js/prod/' + file.sub(/^(?:[^\/]*\/)?(.*)$/, '\1'), 'r'
    f.each_line {|line|
      data += line
    }
    f.close
    File.delete 'js/prod/' + file.sub(/^(?:[^\/]*\/)?(.*)$/, '\1')
  }
  pack = File.open 'js/prod/' + name + '.js', 'w+'
  pack.write data
  pack.close
}

