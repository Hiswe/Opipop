require 'conf/jspack.rb'

# LOOP ON EACH PACK
JSPack.each {|name, files|
  # PACK ALL PACK'S FILES IN ONE
  puts '... packing ' + name
  data = ''
  files.each{|file|
    f = File.open 'js/_gen/' + file, 'r'
    f.each_line {|line|
      data += line
    }
    f.close
  }
  pack = File.open 'js/_prod/' + name + '.js', 'w+'
  pack.write data
  pack.close
}

