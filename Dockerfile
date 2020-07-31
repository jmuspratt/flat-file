FROM php:7-fpm

# Add the `non-free` Debian source for the `libfdk-aac-dev` package
RUN apt-get update && apt-get install -y \
  software-properties-common && \
  apt-add-repository non-free && \
  apt-get update

RUN apt-get install -y \
  libjpeg62-turbo-dev \
  libass-dev \
  libvorbis-dev \
  wget \
  nasm \
  yasm \
  libx265-dev \
  libnuma-dev \
  libvpx-dev \
  libmp3lame-dev \
  libopus-dev \
  libx264-dev \
  libfdk-aac-dev

RUN mkdir ~/ffmpeg_sources && cd ~/ffmpeg_sources && \
  wget -O ffmpeg-4.2.2.tar.bz2 https://ffmpeg.org/releases/ffmpeg-4.2.2.tar.bz2 && \
  tar xjvf ffmpeg-4.2.2.tar.bz2 && \
  cd ffmpeg-4.2.2 && \
  PKG_CONFIG_PATH="$HOME/ffmpeg_build/lib/pkgconfig" ./configure \
  --prefix="$HOME/ffmpeg_build" \
  --pkg-config-flags="--static" \
  --extra-cflags="-I$HOME/ffmpeg_build/include" \
  --extra-ldflags="-L$HOME/ffmpeg_build/lib" \
  --extra-libs="-lpthread -lm" \
  --bindir="/usr/local/bin" \
  --enable-libfdk-aac \
  --enable-gpl \
  --enable-libass \
  --enable-libfreetype \
  --enable-libmp3lame \
  --enable-libopus \
  --enable-libvorbis \
  --enable-libvpx \
  --enable-libx264 \
  --enable-libx265 \
  --enable-nonfree && \
  make -j8 && \
  make install -j8 && \
  hash -r

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd
