<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  Pagination,
  PaginationEllipsis,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev,
} from '@/components/ui/pagination'
import { Link } from '@inertiajs/vue3'
import { ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight } from 'lucide-vue-next'
import { computed } from 'vue'

interface LinkItem {
  url: string | null
  label: string
  active: boolean
}

const props = defineProps<{
  links: LinkItem[]
  maxVisiblePages?: number
}>()

const currentPage = computed(() => {
  const activePage = props.links.find(link => link.active)
  return activePage ? Number(activePage.label) : 1
})

const totalPages = computed(() =>
  props.links
    .filter(link => Number.isInteger(+link.label))
    .map(link => +link.label)
    .sort((a, b) => b - a)[0] || 1
)

// const previousLink = computed(() =>
//   props.links.find(link => link.label.toLowerCase().includes('anterior'))
// )

// const nextLink = computed(() =>
//   props.links.find(link => link.label.toLowerCase().includes('siguiente'))
// )

const previousLink = computed(() => props.links[0])
const nextLink = computed(() => props.links[props.links.length - 1])

const firstLink = computed(() => props.links.find(link => link.label === '1'))
const lastLink = computed(() => props.links.find(link => Number(link.label) === totalPages.value))

</script>

<template>
  <Pagination :total="totalPages" :items-per-page="1" :default-page="currentPage"
    :sibling-count="Math.floor(((props.maxVisiblePages ?? 4) - 1) / 2)" show-edges>
    <PaginationList v-slot="{ items }" class="flex items-center gap-1">
      <!-- First Page -->
      <PaginationFirst as-child class="border dark:border-gray-600 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600/60 transition">
        <Link :href="firstLink?.url || '#'" class="w-10 h-10 p-0 flex items-center justify-center "
          :class="{ 'pointer-events-none opacity-50': !firstLink?.url || currentPage === 1 }">
        <ChevronsLeft />
        </Link>
      </PaginationFirst>

      <!-- Previous Page -->
      <PaginationPrev as-child class="border dark:border-gray-600 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600/60 transition">
        <Link :href="previousLink?.url || '#'" class="w-10 h-10 p-0 flex items-center justify-center"
          :class="{ 'pointer-events-none opacity-50': !previousLink?.url || currentPage === 1 }">
        <ChevronLeft />
        </Link>
      </PaginationPrev>

      <!-- Page Numbers -->
      <template v-for="(item, index) in items" :key="index">
        <PaginationListItem v-if="item.type === 'page'" :value="item.value" as-child>
          <Link :href="props.links.find(link => Number(link.label) === item.value)?.url || '#'">
          <Button
            class="w-10 h-10 p-0 border rounded-lg data-[selected]:!bg-white data-[selected]:shadow-sm data-[selected]:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600/60 transition"
            :class="{
              'bg-black text-white hover:bg-gray-800': item.value === currentPage,
            }" :variant="item.value === currentPage ? 'default' : 'outline'">
            {{ item.value }}
          </Button>
          </Link>
        </PaginationListItem>
        <PaginationEllipsis v-else :index="index" />
      </template>

      <!-- Next Page -->
      <PaginationNext as-child class="border dark:border-gray-600 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600/60 transition">
        <Link :href="nextLink?.url || '#'" class="w-10 h-10 p-0 flex items-center justify-center"
          :class="{ 'pointer-events-none opacity-50': !nextLink?.url || currentPage === totalPages }">
        <ChevronRight />
        </Link>
      </PaginationNext>

      <!-- Last Page -->
      <PaginationLast as-child class="border dark:border-gray-600 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600/60 transition">
        <Link :href="lastLink?.url || '#'" class="w-10 h-10 p-0 flex items-center justify-center"
          :class="{ 'pointer-events-none opacity-50': !lastLink?.url || currentPage === totalPages }">
        <ChevronsRight />
        </Link>
      </PaginationLast>
    </PaginationList>
  </Pagination>
</template>
