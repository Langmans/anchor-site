(function() {

	var keywords = ('abstract and array as break case catch cfunction class clone ' + 
		'const continue declare default die do else elseif enddeclare endfor endforeach ' + 
		'endif endswitch endwhile extends final for foreach function include include_once ' + 
		'global goto if implements interface instanceof namespace new old_function or private ' + 
		'protected public return require require_once static switch throw try use var while xor').split(' ');

	var rules = [
		[/(\/\*(?:[^*\n]|\*+[^\/\*])*\*+\/)/g, "<span class='comment'>$1</span>"],
		[/(\/\/[^\n]*)/g, "<span class='comment'>$1</span>"],
		[new(RegExp)('\\b(' + keywords.join('|') + ')\\b', 'g'), "<span class='keyword'>$1</span>"],
		[new(RegExp)('([a-z0-9_]+)(\s?)\\(', 'ig'), "<span class='identifier'>$1</span>$2("],
		[/(\$[a-z0-9]+)/ig, "<span class='tag'>$1</span>"],
		[/\b([0-9]+(?:\.[0-9]+)?)\b/g, "<span class='number'>$1</span>"]
	];

	var blocks = document.querySelectorAll('pre > code');

	for(var i = 0; i < blocks.length; i++) {
		var block = blocks[i],
			text = (block.textContent || block.innerText).replace(/</g, "&lt;").replace(/>/g, "&gt;");

		for(var r = 0; r < rules.length; r++) {
			var rule = rules[r];
			text = text.replace(rule[0], rule[1]);
		}

		block.innerHTML = text;
	};

}());