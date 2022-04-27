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
              Items
              <Button
                style="float: right; margin-left: 5px"
                @click="toSubCategory()"
                >></Button
              >
              <Button @click="addModal = true" class="add-category"
                ><Icon type="md-add" />Add New Item
              </Button>
            </p>

            <div class="_overflow _table_div">
              <table class="_table">
                <!-- TABLE TITLE -->
                <tr>
                  <th class="subcategory-image"><span>Image</span></th>
                  <th class="subcategory-name"><span>Name</span></th>
                  <th class="subcategory-name"><span>Function Name</span></th>
                  <th class="subcategory-price"><span>Price</span></th>
                  <th class="subcategory-price"><span>Original Price</span></th>
                  <th class="subcategory-in-offer"><span>InOffer</span></th>
                  <th class="subcategory-in-offer"><span>IsNew</span></th>
                  <th class="subcategory-in-offer"><span>Gender</span></th>
                  <th class="subcategory-in-offer"><span>IsPurchased</span></th>
                  <th class="subcategory-id">
                    <span>Parent Category</span>
                  </th>
                  <th class="subcategory-id">
                    <span>Parent SubCategory</span>
                  </th>
                  <th class="subCategory-action">Action</th>
                </tr>
                <!-- TABLE TITLE -->

                <!-- ITEMS -->
                <tr v-for="(item, i) in items" :key="i">
                  <!-- <td>{{ tag.id }}</td> -->
                  <td style="text-align: center">
                    <div
                      style="
                        display: flex;
                        align-items: center;
                        justify-content: center;
                      "
                    >
                      <img
                        :src="item.itemUrl"
                        style="height: 80px; width: 80px"
                      />
                    </div>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.itemName }}</span>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.itemFunctionName }}</span>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.itemPrice }}</span>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.itemOriginalPrice }}</span>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.inOffer ? true : false }}</span>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.isNew ? true : false }}</span>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.gender }}</span>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.isPurchased ? true : false }}</span>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.categoryId }}</span>
                  </td>
                  <td style="text-align: center">
                    <span>{{ item.subCategoryId }}</span>
                  </td>
                  <td style="text-align: center">
                    <Button
                      type="info"
                      size="small"
                      @click="showEditModal(item, i)"
                      class="update-category"
                      >Update</Button
                    >
                    <Button
                      type="error"
                      size="small"
                      @click="showDeletingModal(item, i)"
                      :loading="item.isDeleting"
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
            title="Add New Item"
            :mask-closable="false"
            :closable="false"
          >
            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-name"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Name:</label
              >
              <Input
                id="item-name"
                class="item-input"
                v-model="data.itemName"
                placeholder="Please input Item's name"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-function-name"
                style="
                  font-weight: bold;
                  margin-right: 0px;
                  margin-bottom: 0px;
                  width: 170px;
                "
                >Function Name:</label
              >
              <Input
                id="item-function-name"
                class="item-input"
                v-model="data.itemFunctionName"
                placeholder="Please input Item's function name"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-image"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Image:</label
              >
              <Input
                id="item-image"
                class="item-input"
                v-model="data.itemImage"
                placeholder="Please input Item's image URL"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-price"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Price:</label
              >
              <Input
                id="item-price"
                class="item-input"
                type="number"
                v-model="data.itemPrice"
                placeholder="Please input Item's price"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-original-price"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Original Price:</label
              >
              <Input
                id="item-original-price"
                class="item-input"
                type="number"
                v-model="data.itemOriginalPrice"
                placeholder="Please input Item's original price"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-gender"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Gender:</label
              >
              <Input
                id="item-gender"
                class="item-input"
                v-model="data.itemGender"
                placeholder="Please input Item's gender"
              />
            </div>

            <div style="display: flex">
              <div class="item-in-offer-field">
                <input
                  class="item-inOffer"
                  id="inOffer"
                  type="checkbox"
                  v-model="data.itemInOffer"
                />
                <label for="inOffer" style="font-weight: bold; margin: 0px"
                  >InOffer</label
                >
              </div>

              <div class="item-in-offer-field">
                <input
                  class="item-inOffer"
                  id="isNew"
                  type="checkbox"
                  v-model="data.itemIsNew"
                />
                <label for="isNew" style="font-weight: bold; margin: 0px"
                  >IsNew</label
                >
              </div>

              <div class="item-in-offer-field">
                <input
                  class="item-inOffer"
                  id="isPurchased"
                  type="checkbox"
                  v-model="data.itemPurchased"
                />
                <label for="isPurchased" style="font-weight: bold; margin: 0px"
                  >IsPurchased</label
                >
              </div>
            </div>

            <div slot="footer">
              <Button type="default" @click="addModal = false">Cancel</Button>
              <Button
                type="primary"
                @click="addItem"
                :disabled="isAdding"
                :loading="isAdding"
                >{{ isAdding ? "Adding.." : "Add" }}</Button
              >
            </div>
          </Modal>
          <!-- Tag editing modal -->
          <Modal
            v-model="editModal"
            title="Update Item"
            :mask-closable="false"
            :closable="false"
          >
            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-name-update"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Name:</label
              >
              <Input
                id="item-name-update"
                class="item-input"
                v-model="editData.itemName"
                placeholder="Please input Item's name"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-function-name-update"
                style="
                  font-weight: bold;
                  margin-right: 0px;
                  margin-bottom: 0px;
                  width: 170px;
                "
                >Function Name:</label
              >
              <Input
                id="item-function-name-update"
                class="item-input"
                v-model="editData.itemFunctionName"
                placeholder="Please input Item's function name"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-image-update"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Image:</label
              >
              <Input
                id="item-image-update"
                class="item-input"
                v-model="editData.itemImage"
                placeholder="Please input Item's image URL"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-price-update"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Price:</label
              >
              <Input
                id="item-price-update"
                class="item-input"
                type="number"
                v-model="editData.itemPrice"
                placeholder="Please input Item's price"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-original-price-update"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Original Price:</label
              >
              <Input
                id="item-original-price-update"
                class="item-input"
                type="number"
                v-model="editData.itemOriginalPrice"
                placeholder="Please input Item's original price"
              />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 5px">
              <label
                for="item-gender"
                style="
                  font-weight: bold;
                  margin-right: 15px;
                  margin-bottom: 0px;
                  width: 150px;
                "
                >Gender:</label
              >
              <Input
                id="item-gender"
                class="item-input"
                v-model="editData.itemGender"
                placeholder="Please input Item's gender"
              />
            </div>

            <div style="display: flex">
              <div class="item-in-offer-field">
                <input
                  class="item-inOffer"
                  id="inOffer"
                  type="checkbox"
                  v-model="editData.itemInOffer"
                />
                <label for="inOffer" style="font-weight: bold; margin: 0px"
                  >InOffer</label
                >
              </div>

              <div class="item-in-offer-field">
                <input
                  class="item-inOffer"
                  id="isNewUpdate"
                  type="checkbox"
                  v-model="editData.itemIsNew"
                />
                <label for="isNewUpdate" style="font-weight: bold; margin: 0px"
                  >IsNew</label
                >
              </div>

              <div class="item-in-offer-field">
                <input
                  class="item-inOffer"
                  id="isPurchasedUpdate"
                  type="checkbox"
                  v-model="editData.itemPurchased"
                />
                <label
                  for="isPurchasedUpdate"
                  style="font-weight: bold; margin: 0px"
                  >IsPurchased</label
                >
              </div>
            </div>

            <div slot="footer">
              <Button type="default" @click="editModal = false">Cancel</Button>
              <Button
                type="primary"
                @click="editItem"
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
              <p>Are you sure you want to delete this Item?</p>
            </div>
            <div slot="footer">
              <Button
                type="error"
                size="large"
                long
                :loading="isDeleting"
                :disabled="isDeleting"
                @click="itemDelete"
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
        itemImage: "",
        itemName: "",
        itemFunctionName: "",
        itemPrice: null,
        itemOriginalPrice: null,
        itemInOffer: 0,
        itemIsNew: 0,
        subCategoryId: "",
        categoryId: "",
        itemGender: "",
        itemPurchased: 0,
      },
      addModal: false,
      editModal: false,
      isAdding: false,
      items: [],
      editData: {
        itemName: "",
        itemFunctionName: "",
        itemImage: "",
        itemInOffer: 0,
        itemIsNew: 0,
        itemPrice: null,
        itemOriginalPrice: "",
        subCategoryId: "",
        categoryId: "",
        itemGender: "",
        itemPurchased: 0,
      },
      index: -1,
      showDeleteModal: false,
      isDeleting: false,
      deleteItem: {},
      deletingIndex: -1,
    };
  },

  methods: {
    async addItem() {
      if (this.data.itemName.trim() == "") return this.e("Required Field");
      console.log("data => ", this.data);
      const res = await this.callApi("post", "/items/create_item", this.data);
      console.log("added res status => ", res);
      if (res.status == 201) {
        this.items.unshift(res.data);
        this.s("A New Item is added successfully!");
        this.addModal = false;
        this.data.itemImage = "";
        this.data.itemName = "";
        this.data.itemFunctionName = "";
        this.data.itemPrice = null;
        this.data.itemOriginalPrice = null;
        this.data.itemInOffer = 0;
        this.data.itemIsNew = 0;
        this.data.itemGender = "";
        this.data.itemPurchased = 0;
      } else {
        if (res.status == 422) {
          if (res.data.errors.itemName) {
            this.e(res.data.errors.itemName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    async editItem() {
      this.editData.categoryId = this.$route.params.categoryId;
      this.editData.subCategoryId = this.$route.params.subCategoryId;
      if (this.editData.itemName.trim() == "") return this.e("Required Field");
      const res = await this.callApi("post", "/items/edit_item", this.editData);
      if (res.status == 200) {
        this.items[this.index].itemName = this.editData.itemName;
        this.items[this.index].itemFunctionName =
          this.editData.itemFunctionName;
        this.items[this.index].itemUrl = this.editData.itemImage;
        this.items[this.index].itemPrice = this.editData.itemPrice;
        this.items[this.index].itemOriginalPrice =
          this.editData.itemOriginalPrice;
        this.items[this.index].inOffer = this.editData.itemInOffer;
        this.items[this.index].isNew = this.editData.itemIsNew;
        this.items[this.index].gender = this.editData.itemGender;
        this.items[this.index].isPurchased = this.editData.itemPurchased;
        this.s("The Item has been updated!");
        this.editModal = false;
      } else {
        if (res.status == 422) {
          if (res.data.errors.itemName) {
            this.e(res.data.errors.itemName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    showEditModal(item, index) {
      let obj = {
        id: item.id,
        itemName: item.itemName,
        itemFunctionName: item.itemFunctionName,
        itemImage: item.itemUrl,
        itemPrice: item.itemPrice,
        itemOriginalPrice: item.itemOriginalPrice,
        itemInOffer: item.inOffer,
        itemIsNew: item.isNew,
        itemGender: item.gender,
        itemPurchased: item.isPurchased,
      };
      this.editData = obj;
      this.editModal = true;
      this.index = index;
    },
    async itemDelete() {
      this.isDeleting = true;
      const res = await this.callApi(
        "post",
        "/items/delete_item",
        this.deleteItem
      );
      if (res.status == 200) {
        this.items.splice(this.deletingIndex, 1);
        this.s("The Item has been deleted!");
      } else {
        this.swr();
      }
      this.isDeleting = false;
      this.showDeleteModal = false;
    },
    showDeletingModal(item, i) {
      this.deleteItem = item;
      this.deletingIndex = i;
      this.showDeleteModal = true;
    },
    toSubCategory() {
      this.$router.push({
        name: "SubCategory",
        params: { categoryId: this.$route.params.categoryId },
      });
    },
  },

  async created() {
    this.data.categoryId = this.$route.params.categoryId;
    this.data.subCategoryId = this.$route.params.subCategoryId;
    console.log("subCategory ID => ", this.$route.params.subCategoryId);
    const res = await this.callApi(
      "get",
      "/items/get_items/" + this.$route.params.subCategoryId
    );
    if (res.status == 200) {
      this.items = res.data;
      console.log("Items => ", this.items);
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
.subCategory-action {
  text-align: center;
}
.subcategory-id {
  text-align: center;
}
.subcategory-name {
  text-align: center;
}
.subcategory-image {
  text-align: center;
}
.subcategory-name {
  text-align: center;
}
.subcategory-price {
  text-align: center;
}
.subcategory-in-offer {
  text-align: center;
}
.update-category {
  margin-bottom: 5px;
  width: 90px;
}
.delete-category {
  margin-bottom: 5px;
  width: 90px;
}
.item-input {
  margin-bottom: 10px;
}
.item-inOffer {
  width: 20px;
  height: 20px;
  cursor: pointer;
  margin-right: 10px;
}
.item-in-offer-field {
  display: flex;
  align-items: center;
  margin-right: 10px;
}
</style>