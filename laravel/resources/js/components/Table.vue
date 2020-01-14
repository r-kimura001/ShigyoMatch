<template>
  <div class="Table">
    <table>
      <thead>
        <tr>
          <th v-if="operation" class="Table_headText --operation">操作</th>
          <th
            v-for="(label, index) in labels"
            :key="index"
            class="Table_headText"
          >
            {{ label.name }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(record, index) in list" :key="index">
          <td v-if="operation">
            <div class="Button --minimum --green" @click="editClick(record.id)">
              <i class="far fa-edit u-mr5"></i>編集
            </div>
            <div
              class="Button --minimum --danger"
              @click="deleteClick(record.id)"
            >
              <i class="fas fa-trash-alt u-mr5"></i>削除
            </div>
          </td>
          <td v-for="(labelObj, index) in labels" :key="index">
            <div
              v-if="isDouble(labelObj)"
              class="HorizontalLayout --vertical"
              :class="justify(labelObj)"
            >
              <div v-if="hasIcon(labelObj)" class="HorizontalLayout_col">
                <span
                  class="Table_icon"
                  :style="bgImage(thumbSrc(record[labelObj.withIcon]))"
                ></span>
              </div>
              <div class="HorizontalLayout_col">
                <RouterLink
                  v-if="hasLink(labelObj)"
                  :to="
                    `/${labelObj.link.path}/${record[labelObj.link.paramKey]}`
                  "
                  tag="span"
                  class="Table_dataText --link"
                >
                  {{
                    dataFormat(
                      record[labelObj.key][labelObj.key2],
                      labelObj.key2
                    )
                  }}
                </RouterLink>
                <span
                  v-else-if="hasTag(labelObj)"
                  class="Tag"
                  :style="
                    bgColor(record[labelObj.key][labelObj.tag.bgColorKey])
                  "
                >
                  {{
                    dataFormat(
                      record[labelObj.key][labelObj.key2],
                      labelObj.key2
                    )
                  }}
                </span>
                <span v-else class="Table_dataText">{{
                  dataFormat(record[labelObj.key][labelObj.key2], labelObj.key2)
                }}</span>
              </div>
            </div>
            <!-- HorizontalLayout -->
            <div
              v-else
              class="HorizontalLayout --vertical"
              :class="justify(labelObj)"
            >
              <div v-if="hasIcon(labelObj)" class="HorizontalLayout_col">
                <span
                  class="Table_icon"
                  :style="bgImage(record[labelObj.withIcon])"
                ></span>
              </div>
              <div class="HorizontalLayout_col">
                <RouterLink
                  v-if="hasLink(labelObj)"
                  :to="
                    `/${labelObj.link.path}/${record[labelObj.link.paramKey]}`
                  "
                  tag="span"
                  class="Table_dataText --link"
                >
                  {{ dataFormat(record[labelObj.key], labelObj.key) }}
                </RouterLink>
                <span
                  v-else-if="hasTag(labelObj)"
                  class="Tag"
                  :style="
                    bgColor(record[labelObj.key][labelObj.tag.bgColorKey])
                  "
                >
                  {{
                    dataFormat(
                      record[labelObj.key][labelObj.key2],
                      labelObj.key2
                    )
                  }}
                </span>
                <span v-else class="Table_dataText">{{
                  dataFormat(record[labelObj.key], labelObj.key)
                }}</span>
              </div>
            </div>
            <!-- HorizontalLayout -->
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import styles from '@/mixins/styles'
export default {
  mixins: [styles],
  props: {
    list: {
      type: Array,
      required: true,
      default: () => [],
    },
    labels: {
      type: Array,
      required: true,
      default: () => [],
    },
    operation: {
      type: Boolean,
      required: true,
      default: false,
    },
  },
  methods: {
    hasIcon(obj) {
      return 'withIcon' in obj
    },
    isDouble(obj) {
      return 'key2' in obj
    },
    hasLink(obj) {
      return 'link' in obj
    },
    hasTag(obj) {
      return 'tag' in obj
    },
    dataFormat(text, key) {
      if (key === 'fee') {
        return `${text.toLocaleString()}円`
      } else {
        return text
      }
    },
    justify(obj) {
      return {
        '--justifyCenter': !this.hasLink(obj),
      }
    },
    editClick(id) {
      this.$emit('onClickEdit', id)
    },
    deleteClick(id) {
      this.$emit('onClickDelete', id)
    },
  },
}
</script>
