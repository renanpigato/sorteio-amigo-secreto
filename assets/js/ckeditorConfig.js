CKEDITOR.ENTER_P = 1;
CKEDITOR.ENTER_BR = 2;
CKEDITOR.ENTER_DIV = 3;
CKEDITOR.config = {
  autoUpdateElement    : true,
  defaultLanguage      : 'pt',
  enterMode            : CKEDITOR.ENTER_P,
  forceEnterMode       : false,
  shiftEnterMode       : CKEDITOR.ENTER_BR,
  docType              : '<!DOCTYPE html>',
  fullPage             : false,
  removePlugins        : 'sourcearea,sourcedialog',
  protectedSource      : [
    '/<\?[\s\S]*?\?>/g',
    '/<%[\s\S]*?%>/g',
    '/(<asp:[^\>]+>[\s|\S]*?<\/asp:[^\>]+>)|(<asp:[^\>]+\/>)/gi'
  ],
  tabIndex          : 0,
  baseFloatZIndex   : 10000,
  blockedKeystrokes : [
    CKEDITOR.CTRL + 66, // Ctrl+B
    CKEDITOR.CTRL + 73, // Ctrl+I
    CKEDITOR.CTRL + 85 // Ctrl+U
  ]
};
