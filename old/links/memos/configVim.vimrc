" la base
syntax on
set number

" divers
set showmatch
set tabstop=4
set mouse=a
let c_space_errors=1

" utf-8
set encoding=utf-8
setglobal fileencoding=utf-8

" 80 char. par ligne
"highlight OverLength ctermbg=red ctermfg=white guibg=#592929
"match OverLength /\%81v.\+/

" header *.c
autocmd bufnewfile *.c so ~/.myVimHeader
autocmd bufnewfile *.c exe "1," . 10 . "g/File Name :.*/s//File Name : " .expand("%")
autocmd bufnewfile *.c exe "1," . 10 . "g/Creation Date :.*/s//Creation Date : " .strftime("%d-%m-%y %H:%M:%S")
autocmd Bufwritepre,filewritepre *.c execute "normal ma"
autocmd Bufwritepre,filewritepre *.c exe "1," . 10 . "g/Last Modified :.*/s/Last Modified :.*/Last Modified : " .strftime("%d-%m-%y %H:%M:%S")
autocmd bufwritepost,filewritepost *.c execute "normal `a"

" diver bis
autocmd BufEnter *.c,*.h set shiftwidth=4 expandtab
autocmd BufLeave *.c,*.h set noexpandtab

" header *.h
function Insert_gates()
	let gatename = substitute(toupper(expand("%:t")), "\\.", "_", "g")
	execute "normal! i#ifndef " . gatename
	execute "normal! o# define " . gatename . "\n"
	execute "normal! Go#endif /* " . gatename . " */"
	normal! kk
endfunction

autocmd BufNewFile *.{h,hpp} call Insert_gates()

