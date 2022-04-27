<template>
  <div>
    <div>
      <div class="content">
        <div class="container-fluid">
          <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
          <div
            class="
              _1adminOverveiw_table_recent
              _box_shadow
              _border_radious
              _mar_b30
              _p20
            "
          >
            <p class="_title0">
              SubCategories
              <Button
                style="float: right; margin-left: 5px"
                @click="toCategory()"
                >></Button
              >
              <Button @click="addModal = true" class="add-category"
                ><Icon type="md-add" />Add New SubCategory
              </Button>
            </p>

            <div class="_overflow _table_div">
              <table class="_table">
                <!-- TABLE TITLE -->
                <tr>
                  <th class="subcategory-name">Name</th>
                  <!-- <th class="subcategory-name">Gender</th> -->
                  <th class="subCategory-id">Parent Category</th>
                  <!-- <th>Nom du morceau</th>
                  <th>Ajouté le</th> -->
                  <th>Action</th>
                </tr>
                <!-- TABLE TITLE -->

                <!-- ITEMS -->
                <tr v-for="(subCategory, i) in subCategories" :key="i">
                  <!-- <td>{{ tag.id }}</td> -->
                  <td @click="toItem(subCategory)" style="cursor: pointer">
                    <span>{{ subCategory.subCategoryName }}</span>
                  </td>
                  <!-- <td
                    @click="toItem(subCategory)"
                    style="cursor: pointer; text-align: left"
                  >
                    <span>{{ subCategory.gender }}</span>
                  </td> -->
                  <td
                    @click="toItem(subCategory)"
                    style="cursor: pointer; text-align: left"
                  >
                    {{ subCategory.categoryId }}
                  </td>
                  <td>
                    <Button
                      type="info"
                      size="small"
                      @click="showEditModal(subCategory, i)"
                      class="update-category"
                      >Update</Button
                    >
                    <Button
                      type="error"
                      size="small"
                      @click="showDeletingModal(subCategory, i)"
                      :loading="subCategory.isDeleting"
                      class="delete-category"
                      >Delete</Button
                    >
                  </td>
                </tr>
                <!-- ITEMS -->
              </table>
            </div>
          </div>
          <!-- Tag adding modal -->
          <Modal
            v-model="addModal"
            title="Add New SubCategory"
            :mask-closable="false"
            :closable="false"
          >
            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="subcategory-name"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                "
                >Name:</label
              >
              <Input
                id="subcategory-name"
                v-model="data.subCategoryName"
                placeholder="Please input SubCategory's name"
              />
            </div>

            <!-- <div style="display: flex; align-items: center">
              <label
                for="subcategory-gender"
                style="font-weight: bold; margin-right: 5px; margin-bottom: 0px"
                >Gender:</label
              >
              <Input
                id="subcategory-gender"
                v-model="data.subCategoryGender"
                placeholder="Please input SubCategory's gender"
              />
            </div> -->

            <div slot="footer">
              <Button type="default" @click="addModal = false">Cancel</Button>
              <Button
                type="primary"
                @click="addSubCategory"
                :disabled="isAdding"
                :loading="isAdding"
                >{{ isAdding ? "Adding.." : "Add" }}</Button
              >
            </div>
          </Modal>
          <!-- Tag editing modal -->
          <Modal
            v-model="editModal"
            title="Update SubCategory"
            :mask-closable="false"
            :closable="false"
          >
            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="subcategory-name-update"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                "
                >Name:</label
              >
              <Input
                id="subcategory-name-update"
                v-model="editData.subCategoryName"
                placeholder="Please input SubCategory's name"
              />
            </div>

            <!-- <div style="display: flex; align-items: center">
              <label
                for="subcategory-gender-update"
                style="font-weight: bold; margin-right: 5px; margin-bottom: 0px"
                >Gender:</label
              >
              <Input
                id="subcategory-gender-update"
                v-model="editData.subCategoryGender"
                placeholder="Please input SubCategory's gender"
              />
            </div> -->

            <div slot="footer">
              <Button type="default" @click="editModal = false">Cancel</Button>
              <Button
                type="primary"
                @click="editSubCategory"
                :disabled="isAdding"
                :loading="isAdding"
                >{{ isAdding ? "Updating.." : "Update" }}</Button
              >
            </div>
          </Modal>
          <!-- Tag deleting modal confirmation -->
          <Modal v-model="showDeleteModal" width="360">
            <p slot="header" style="color: #f60; text-align: center">
              <Icon type="ios-information-circle"></Icon>
              <span>Delete Confirmation</span>
            </p>
            <div style="text-align: center">
              <p>Are you sure you want to delete this SubCategory?</p>
            </div>
            <div slot="footer">
              <Button
                type="error"
                size="large"
                long
                :loading="isDeleting"
                :disabled="isDeleting"
                @click="deleteSubCategory"
                >OK</Button
              >
            </div>
          </Modal>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        subCategoryName: "",
        // subCategoryGender: "",
        categoryId: "",
      },
      addModal: false,
      editModal: false,
      isAdding: false,
      subCategories: [],
      editData: {
        subCategoryName: "",
        // subCategoryGender: "",
        categoryId: "",
      },
      index: -1,
      showDeleteModal: false,
      isDeleting: false,
      deleteItem: {},
      deletingIndex: -1,
    };
  },

  methods: {
    async addSubCategory() {
      if (this.data.subCategoryName.trim() == "")
        return this.e("Required Field");
      const res = await this.callApi(
        "post",
        "/SubCategories/create_sub_category",
        this.data
      );
      console.log("added res status => ", res);
      if (res.status == 201) {
        this.subCategories.unshift(res.data);
        this.s("A New Category is added successfully!");
        this.addModal = false;
        this.data.subCategoryName = "";
        // this.data.subCategoryGender = "";
      } else {
        if (res.status == 422) {
          if (res.data.errors.subCategoryName) {
            this.e(res.data.errors.subCategoryName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    async editSubCategory() {
      this.editData.categoryId = this.$route.params.categoryId;
      if (this.editData.subCategoryName.trim() == "")
        return this.e("Required Field");
      const res = await this.callApi(
        "post",
        "/SubCategories/edit_sub_category",
        this.editData
      );
      if (res.status == 200) {
        this.subCategories[this.index].subCategoryName =
          this.editData.subCategoryName;
        // this.subCategories[this.index].gender = this.editData.subCategoryGender;
        this.s("The SubCategory has been updated!");
        this.editModal = false;
      } else {
        if (res.status == 422) {
          if (res.data.errors.subCategoryName) {
            this.e(res.data.errors.subCategoryName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    showEditModal(subCategory, index) {
      let obj = {
        id: subCategory.id,
        subCategoryName: subCategory.subCategoryName,
        // subCategoryGender: subCategory.gender,
      };
      this.editData = obj;
      this.editModal = true;
      this.index = index;
    },
    async deleteSubCategory() {
      this.isDeleting = true;
      const res = await this.callApi(
        "post",
        "/SubCategories/delete_sub_category_single",
        this.deleteItem
      );
      if (res.status == 200) {
        this.subCategories.splice(this.deletingIndex, 1);
        this.s("The SubCategory has been deleted!");
      } else {
        this.swr();
      }
      this.isDeleting = false;
      this.showDeleteModal = false;
    },
    showDeletingModal(subCategory, i) {
      this.deleteItem = subCategory;
      this.deletingIndex = i;
      this.showDeleteModal = true;
    },
    toItem(subCategoryInfo) {
      console.log("Sub Category Info => ", subCategoryInfo);
      this.$router.push({
        name: "Items",
        params: {
          categoryId: subCategoryInfo.categoryId,
          subCategoryId: subCategoryInfo.id,
        },
      });
    },
    toCategory() {
      this.$router.push({
        name: "Category",
      });
    },
  },

  async created() {
    this.data.categoryId = this.$route.params.categoryId;
    console.log("CategoryId => ", this.$route.params.categoryId);
    const res = await this.callApi(
      "get",
      "/SubCategories/get_sub_categories/" + this.$route.params.categoryId
    );
    if (res.status == 200) {
      this.subCategories = res.data;
      console.log("SubCategories => ", this.subCategories);
    } else {
      this.swr();
    }
  },
};
</script>

<style scoped>
.add-category {
  float: right;
}
.subcategory-id {
  text-align: center;
}
.subcategory-name {
}
.update-category {
  margin-bottom: 5px;
  width: 90px;
}
.delete-category {
  margin-bottom: 5px;
  width: 90px;
}
</style>