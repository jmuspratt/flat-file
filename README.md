# 📸 Flat File
Self-hosted web photo galleries. The only admin UI is  sFTP and strict file-naming conventions. Built with PHP.

## Done
- Date-prefixed albums
- Date-prefixed text files for outputting heading separators
- Native responsive images (`srcset` and `sizes`)
- Native lazyloading with `loading=lazy`
- Image processing with the GD library
- Video processing (to 720p mp4) with [PHP-FFMPEG](https://github.com/PHP-FFMpeg/PHP-FFMpeg)


## To Do
- [ ] Enlargeable images and video in a modal on click
- [ ] Honor non-16×9 video aspect ratios when processing
- [ ] Improve display of headings on mobile
- [ ] UI to step through albums from album view
