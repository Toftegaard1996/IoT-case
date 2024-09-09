<template>
  <button
      class="bg-green-500 px-4 py-2 rounded-md flex flex-row items-center hover:bg-green-600 transition ease-in-out duration-150">
    <slot />
  </button>
</template>
<script>
export default {
  name: 'GreenButton'
}
</script>
