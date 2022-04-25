<template>
  <Splide :options="{ rewind: true }" aria-label="My Favorite Images">
    <SplideSlide>
      <img src="image1.jpg" alt="Sample 1">
    </SplideSlide>
    <SplideSlide>
      <img src="image2.jpg" alt="Sample 2">
    </SplideSlide>
  </Splide>
</template>

<script>
export default {
  name: 'CarouselSplide'
}
</script>